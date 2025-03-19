<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        // $products = Product::query()->orderBy('updated_at', 'desc')->paginate(8);
        // return view('product.index', ['products' => $products]);
        $products = Product::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(5);
        return view('product.index', [
            'products' => $products
        ]);
    }

    public function view(Product $product){
        return view('product.show', ['product' => $product]);
    }
}
