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
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
    
        [$products, $cartItems] = CartItem::getProductsAndCartItems();
    
        $user = auth()->user();
        if ($user && $user->stripe_customer_id) {
            $customer_id = $user->stripe_customer_id;
        } else {
            // 2. Create a new Stripe Customer
            $customer = \Stripe\Customer::create([
                'name' => $user ? $user->name : null,  // Add the name
                'email' => $user ? $user->email : null,
                // Add other customer details as needed (e.g., address, phone)
                'address' => $user ? [ //Example address
                    'city' => $user->city,
                    'country' => $user->country,
                    'line1' => $user->address,
                    'postal_code' => $user->zip,
                    'state' => $user->state,
                ] : null,
            ]);
    
            $customer_id = $customer->id;
    
            // 3. Store the customer ID
            if ($user) {
                $user->stripe_customer_id = $customer_id;
                $user->save();
            }
        }
    
        // Create a Stripe Checkout Session
    
        $line_items = [];
        foreach ($products as $product) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }
    
        $session = \Stripe\Checkout\Session::create([
            'customer' => $customer_id, // Crucial: Associate the customer with the session
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) .'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route("checkout.failure", [], true),
        ]);
    
        return redirect($session->url, 303);
    }
    public function success(Request $request)
{
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

    try {
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
        if (!$session OR $session->payment_status !== 'paid') {
            return view('checkout.failure');
        }
        $customer = $stripe->customers->retrieve($session->customer);
        $customerName = $session->customer_details->name;
        return view('checkout.success' ,compact('customerName'));
        http_response_code(200);
      } catch (Error $e) {
        return view('checkout.failure');
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
      }
}


    public function failure(Request $request)
    {
        dd($request->all());
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
