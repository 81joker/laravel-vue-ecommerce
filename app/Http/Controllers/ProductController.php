<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductListResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProductListResource::collection($query);
        // return ProductListResource::collection(Product::query()->paginate(  10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductResource $request)
    {
        return ProductResource::make(Product::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return  new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductResource $request, Product $product)
    {
        return new ProductResource($product->update($request->validated()));
        // return ProductResource::make($product->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
         $product->delete();
         return response()->noContent();
    }
}
