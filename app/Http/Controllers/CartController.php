<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Cart;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function index(){
        $cartItems = Cart::getCartItems();
        // https://laravel.com/docs/11.x/collections#method-pluck
        // https://chat.deepseek.com/a/chat/s/0a014204-fb75-4bf4-a109-39ff8a046ab3
        $ids = Arr::pluck($cartItems, 'product_id');
    }
}
