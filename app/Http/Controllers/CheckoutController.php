<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\LineItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Cashier\Checkout;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function store(CheckoutRequest $request): Checkout|RedirectResponse
    {
        $validated = $request->validated();

        $lineItems = [];
        foreach ($validated['items'] as $item) {
            $lineItems[$item['price_id']] = $item['quantity'];
        }

        $checkoutOptions = [
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('home'),
            'shipping_address_collection' => ['allowed_countries' => ['US']],
            'phone_number_collection' => ['enabled' => true],
            'customer_creation' => 'always',
            // TODO: Uncomment once this is reolved in Stripe Dashboard...
            // 'automatic_tax' => ['enabled' => true],
            'metadata' => [
                'cart_items' => json_encode($lineItems),
                'source' => 'website_store',
            ],
        ];

        $shippingOptions = $this->getShippingOptions();
        if (! empty($shippingOptions)) {
            $checkoutOptions['shipping_options'] = $shippingOptions;
        }

        try {
            return Checkout::guest()->create($lineItems, $checkoutOptions);
        } catch (\Exception $e) {
            \Log::error('Checkout creation failed: '.$e->getMessage(), [
                'line_items' => $lineItems,
                'checkout_options' => $checkoutOptions,
            ]);

            return back()->with('error', 'Failed to create checkout session. Please try again.');
        }
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            \Log::error('No session_id provided to checkout success', [
                'query_params' => $request->query(),
                'all_params' => $request->all(),
            ]);

            return redirect()->route('home')->with('error', 'Invalid checkout session.');
        }

        try {
            $stripe = new StripeClient(config('cashier.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId, [
                'expand' => ['line_items', 'line_items.data.price.product', 'customer'],
            ]);

            $existingOrder = Order::query()->where('stripe_checkout_session_id', $sessionId)->first();
            if ($existingOrder) {
                return redirect()->route('home')->with('success', 'Thank you for your order! Order #'.$existingOrder->order_number);
            }

            $order = Order::query()->create([
                'status' => 'processing',
                'subtotal' => $session->amount_subtotal / 100,
                'tax_amount' => $session->amount_total - $session->amount_subtotal > 0 ? ($session->amount_total - $session->amount_subtotal) / 100 : null,
                'shipping_cost' => $session->shipping_cost ? $session->shipping_cost->amount_total / 100 : null,
                'total_amount' => $session->amount_total / 100,
                'currency' => strtoupper($session->currency),
                'customer_email' => $session->customer_details->email,
                'customer_first_name' => $session->customer_details->name ? explode(' ', $session->customer_details->name)[0] : null,
                'customer_last_name' => $session->customer_details->name ? implode(' ', array_slice(explode(' ', $session->customer_details->name), 1)) : null,
                'customer_phone' => $session->customer_details->phone,
                'shipping_address_line_1' => $session->shipping_details?->address?->line1,
                'shipping_address_line_2' => $session->shipping_details?->address?->line2,
                'shipping_city' => $session->shipping_details?->address?->city,
                'shipping_state' => $session->shipping_details?->address?->state,
                'shipping_postal_code' => $session->shipping_details?->address?->postal_code,
                'shipping_country' => $session->shipping_details?->address?->country,
                'payment_status' => 'paid',
                'payment_method' => 'stripe',
                'payment_transaction_id' => $session->payment_intent,
                'payment_completed_at' => now(),
                'stripe_checkout_session_id' => $sessionId,
                'stripe_payment_intent_id' => $session->payment_intent,
                'stripe_customer_id' => is_string($session->customer) ? $session->customer : $session->customer?->id,
            ]);

            foreach ($session->line_items->data as $lineItem) {
                $product = Product::where('stripe_product_id', $lineItem->price->product->id)->first();

                LineItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product ? $product->id : null,
                    'product_name' => $lineItem->description,
                    'product_sku' => $product ? $product->sku : null,
                    'product_description' => $product ? $product->description : null,
                    'product_image_url' => $product ? $product->image_url : null,
                    'quantity' => $lineItem->quantity,
                    'unit_price' => $lineItem->price->unit_amount / 100,
                    'total_price' => $lineItem->amount_total / 100,
                    'currency' => strtoupper($lineItem->currency),
                    'stripe_price_id' => $lineItem->price->id,
                    'stripe_product_id' => $lineItem->price->product->id,
                ]);
            }

            // TODO: Send order confirmation email to customer

            return redirect()->route('home')->with('success', 'Thank you for your order! Order #'.$order->order_number);

        } catch (\Exception $e) {
            \Log::error('Order creation failed: '.$e->getMessage(), [
                'session_id' => $sessionId,
                'error' => $e->getTraceAsString(),
            ]);

            return redirect()->route('home')->with('error', 'There was an issue processing your order. Please contact support.');
        }
    }

    private function getShippingOptions(): array
    {
        try {
            $stripe = new StripeClient(config('cashier.secret'));

            $shippingRates = $stripe->shippingRates->all([
                'active' => true,
                'limit' => 10,
            ]);

            $shippingOptions = [];
            foreach ($shippingRates->data as $rate) {
                $shippingOptions[] = [
                    'shipping_rate' => $rate->id,
                ];
            }

            return $shippingOptions;

        } catch (\Exception $e) {
            \Log::error('Failed to fetch shipping rates: '.$e->getMessage());

            return [];
        }
    }
}
