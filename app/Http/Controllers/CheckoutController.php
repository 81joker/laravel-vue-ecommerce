<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        # See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        // list($products, $cartItems) = $this->getProductsAndCartItems();
        [$products, $cartItems] = CartItem::getProductsAndCartItems();

        $line_items = [];
        foreach ($products as $product) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image],
                        // 'description' => $product->description
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);
        return redirect($session->url, 303);

        // return redirect($session->url, 303);

    }
    public function success()
    {
        dd("sucess");
        // return view('checkout.success');
    }

    public function cancel()
    {
        dd("cancel");
        // return view('checkout.cancel');
    }
    // private function  getProductsAndCartItems()
    // {
    //     $cartItems = Cart::getCartItems();
    //     $ids = Arr::pluck($cartItems, 'product_id');
    //     $products = Product::query()->whereIn('id', $ids)->get();
    //     $cartItems = Arr::keyBy($cartItems, 'product_id');
    //     return [$products , $cartItems];
    // }
}
