<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductListResource;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
Log::info('Request Data (excluding files):', $request->except('image'));

$data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }

        $product = Product::create($data);

        return new ProductResource($product);

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

    private function saveImage(UploadedFile $image)
    {
        // $path = 'images/' . Str::random();
        $path = $image->store('images', 'public');
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' ;
    }
}
