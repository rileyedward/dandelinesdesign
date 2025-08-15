<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Laravel\Cashier\Checkout;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request): Checkout
    {
        $validated = $request->validated();

        $lineItems = [];
        foreach ($validated['items'] as $item) {
            $lineItems[$item['price_id']] = $item['quantity'];
        }

        $checkoutOptions = [
            // TODO: Uncomment once we have this in there.
            // 'success_url' => route('checkout.success'),
            // 'cancel_url' => route('checkout.cancel'),
            'automatic_tax' => ['enabled' => true],
        ];

        $shippingOptions = $this->getShippingOptions();

        if (! empty($shippingOptions)) {
            $checkoutOptions['shipping_options'] = $shippingOptions;
        }

        return Checkout::guest()->create($lineItems, $checkoutOptions);
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
