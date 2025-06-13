<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $search = \request()->get('search');
        $products = Product::query()
            // ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->where($this->renderProducts($search))
            // Both are same result (search by title or description or price) wroite by Nehad
            // ->where(function ($query) use ($search) {
            //     /** @var Builder $query \Illuminate\Database\Query\Builder */
            //     $query->where('title', 'like', "%{$search}%")
            //         ->orWhere('description', 'like', "%{$search}%")
            //         ->orWhere('price', 'like', "%{$search}%");
            // })
            // ->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%")->orWhere('price', 'like', "%{$search}%")

            ->paginate(5);

        return view('product.index', [
            'products' => $products
        ]);
    }

    public function category(Category $category){

       $categories = Category::getAllChildrenByParent($category);

        $products = Product::query()
            ->select('products.*')
            // This mean in jon product_categories table ===>SELECT * FROM product_categories WHERE product_id = [current_product_id]
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories))
             ->orderBy('updated_at', 'desc')
            ->paginate(5);
        return view('product.index', [
            'products' => $products,
        ]);
    }
    // public function category($category){
    //     $products = Product::query()
    //         ->where('category_id', $category->id)
    //         ->orderBy('updated_at', 'desc')
    //         ->paginate(5);
    //     return view('product.index', [
    //         'products' => $products,
    //         'category' => $category
    //     ]);
    // }
    public function view(Product $product){
        return view('product.show', ['product' => $product]);
    }

    private function renderProducts($search = null)
    {
        return function ($query) use ($search) {
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('price', 'like', "%{$search}%");
                });
            }
        };
    }
}
