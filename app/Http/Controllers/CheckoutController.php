<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Cashier\Checkout;

class CheckoutController extends Controller
{
    public function __invoke(Request $request): Checkout
    {
        $priceIds = Price::all()->pluck('stripe_price_id');

        return Checkout::guest()->create([
            $priceIds[0] => 1,
            $priceIds[1] => 1,
        ]);
    }
}
