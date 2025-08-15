<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Cashier\Checkout;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request): Checkout
    {
        $validated = $request->validated();

        $lineItems = [];
        foreach ($validated['items'] as $item) {
            $lineItems[$item['price_id']] = $item['quantity'];
        }

        $checkout = Checkout::guest()->create($lineItems, [
            // TODO: Uncomment once we have this in there.
            // 'success_url' => route('checkout.succees'),
            // 'cancel_url' => route('checkout.cancel'),
        ]);

        return $checkout;
    }
}
