<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\RedirectResponse;
use Laravel\Cashier\Checkout;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request): Checkout|RedirectResponse
    {
        $validated = $request->validated();

        $lineItems = [];
        foreach ($validated['items'] as $item) {
            $lineItems[$item['price_id']] = $item['quantity'];
        }

        $checkoutOptions = [
            'success_url' => route('home'),
            'cancel_url' => route('home'),
            // 'automatic_tax' => ['enabled' => true],
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
