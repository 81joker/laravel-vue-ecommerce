<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;
use App\Models\Payment;
use App\Models\Order;

class CheckoutController extends Controller
{

    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = CartItem::getProductsAndCartItems();

        // /**  @var \App\Models\User $user */
        // $user = $request->user();
        $user = auth()->user();
        if ($user && $user->stripe_customer_id) {
            $customer_id = $user->stripe_customer_id;
        } else {
            // 2. Create a new Stripe Customer
            $customer = \Stripe\Customer::create([
                'name' => $user ? $user->name : null,
                'email' => $user ? $user->email : null,
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
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->price * $cartItems[$product->id]['quantity'];
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
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route("checkout.failure", [], true),
        ]);

        // Order the line items
        $orderDate = [
            'total_price' => $totalPrice,
            'status' => OrderStatus::Unpaid,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ];
        $order = Order::create($orderDate);

        $paymentDate = [
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'status' => PaymentStatus::Pending,
            'type' => 'cc',
            // 'type' => 'stripe',
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'session_id' => $session->id
        ];
        $payment = Payment::create($paymentDate);



        return redirect($session->url, 303);
    }
    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        try {
            $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
            if (!$session or $session->payment_status !== 'paid') {
                return view('checkout.failure', ['error' => 'Payment Session not successful']);
            }

            // First Payment to Status paid
            $payment = Payment::query()->where(['session_id' => $session->id, 'status' => PaymentStatus::Pending])->first();
            if (!$payment) {
                // if (!$payment OR $payment->status !== PaymentStatus::Paid) {
                return view('checkout.failure', ['error' => 'Payment record not found']);
            }
            $payment->status = PaymentStatus::Paid;
            $payment->update();
            // $payment->save();

            // Second Order to Status paid
            $order = $payment->order;
            if (!$order) {
                return view('checkout.failure', ['error' => 'Order not found']);
            }
            $order->status = OrderStatus::Paid;
            $order->update();

            $user = auth()->user();

            // Third Remove from Cart
            CartItem::where('user_id', $user->id)->delete();



            $customer = $stripe->customers->retrieve($session->customer);
            $customerName = $session->customer_details->name;
            return view('checkout.success', compact('customerName'));
        } catch (Error $e) {

            return view('checkout.failure', ['error' => $e->getMessage()]);
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
