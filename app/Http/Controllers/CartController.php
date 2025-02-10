<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(){
        $cartItems = Cart::getCartItems();
        // https://laravel.com/docs/11.x/collections#method-pluck
        // https://chat.deepseek.com/a/chat/s/0a014204-fb75-4bf4-a109-39ff8a046ab3
        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::query()->whereIn('id', $ids)->get();
        $cartItem = Arr::keyBy($cartItems, 'product_id');
        $total = 0;
        foreach($products as $product){
            $total += $product->price * $cartItem[$product->id]['quantity']; ;
            // $total += $cartItem[$product->id]['quantity'] * $product->price;
        }
        return view('cart.index', compact('products', 'cartItem'));
    }

    public function add(Request $request   , Product $product){
        // Cart::add($request->product_id);
        // $quintity = $request->quantity ?? 1;
        $quintity = $request->post('quantity', 1);
        $user = $request->user();
        if($user){
            // $user->cart()->syncWithoutDetaching([$product->id => ['quantity' => $quintity]]);
            $cartItem = CartItem::where(['product_id', $product->id,'user_id', $user->id])->first();
            if($cartItem){
                $cartItem->quantity += $quintity;
                $cartItem->update();
                // $cartItem->save();
                // return redirect()->route('cart.index');
            } else {
                $data = [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $quintity
                ];
                CartItem::create(attributes: $data);
            }
            return response(['count' => Cart::getCartItemsCount()]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items' , '[]') , true);
            $productFound = false;
            foreach($cartItems as &$item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] += $quintity;
                    $productFound = true;
                    break;
                }
                if(!$productFound){
                    $cartItems[] = [
                        'user_id' => null,
                        'product_id' => $product->id,
                        'quantity' => $quintity,
                        'price' => $product->price
                    ];
                }
                // Expaire in 30 days
                Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
                return response(['count' => Cart::getCountFromItems($cartItems)]);
            }
        }

    }

    public function remove(Request $request,Product $product){
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['product_id', $product->id,'user_id', $user->id])->first();
            if($cartItem){
                $cartItem->delete();
            }
            return response(['count' => Cart::getCartItemsCount()]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items' , '[]') , true);
            foreach($cartItems as $i => &$item){
                if($item['product_id'] == $product->id){
                    // unset($cartItems[$i]);
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            // Expaire in 30 days
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
        // Cart::remove($product->id);
        // return redirect()->route('cart.index');
    }

    public function updateQuantity(Request $request,Product $product){
        $quantity = $request->quantity;
        $user = $request->user();
        if($user){
            $cartItem = CartItem::where(['product_id', $product->id,'user_id', $user->id])->update(['quantity' => $quantity]);
            return response(['count' => Cart::getCartItemsCount()]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items' , '[]') , true);
            foreach($cartItems as $i => &$item){
                if($item['product_id'] == $product->id){
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            // Expaire in 30 days
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
