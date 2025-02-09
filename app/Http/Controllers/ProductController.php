<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::query()->orderBy('updated_at', 'desc')->paginate(4);
        return view('product.index', ['products' => $products]);
    }

    public function show(Product $product){
        dd($product);
        return view('product.show', ['product' => $product]);
    }
}
