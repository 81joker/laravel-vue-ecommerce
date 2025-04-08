<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Product;
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
use App\Http\Controllers\Controller;
use App\Models\ProductImage;


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
// Log::info('Request Data (excluding files):', $request->except('image'));

$data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $product = Product::create($data);

        if ($images) {
            // $positions = $request->input('positions', []);
            $this->saveImages($images , [],$product);
        }
        return new ProductResource($product);
        // Just for one image
        // Just for one image
        // $image = $data['image'] ?? null;
        /*
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
        }
        */


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

      /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;


    
               /** @var \Illuminate\Http\UploadedFile[] $images */
               $images = $data['images'] ?? [];
               $product->update($data);
       
               if ($images) {
                   $this->saveImages($images , [],$product);
               }
               return new ProductResource($product);

        /*
        ///////////////***Just for one image ///////////////
        $image = $data['image'] ?? null;
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime'] = $image->getClientMimeType();
            $data['image_size'] = $image->getSize();
            // If there is an old image, delete it
            if ($product->image) {
                Storage::deleteDirectory('/public/' . dirname($product->image));
            }
        }
        
                // $product->update($data);
        
                // return new ProductResource($product);
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
         $product->delete();
         return response()->noContent();
    }



   /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     * @author Nehad Altimimi <nehad.al.timimi@gmail.com>
     */
    private function saveImages($images, $positions = [], Product $product)
    {
        foreach ($positions as $id => $position) {
            ProductImage::query()
                ->where('id', $id)
                ->update(['position' => $position]);
        }

        foreach ($images as $id => $image) {
            $path = 'images/' . Str::random();
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0755, true);
            }
            // $name = Str::random().'.'.$image->getClientOriginalExtension();
            // if (!Storage::putFileAS('public/' . $path, $image, $name)) {
            //     throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            // }
            $name = $image->store('images', 'public');
            if (!Storage::putFileAS('public/' , $image, $image->getClientOriginalName())) {
            // if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
                throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            }

            $relativePath =  '/' . $name;
            // $relativePath = $path . '/' . $name;

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1
            ]);
        }
    }
    /*
    * This method just for one image
    private function saveImage(UploadedFile $image)
    {
        // $path = 'images/' . Str::random();
        $path = $image->store('images', 'public');
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' ;
    }

    */

    // private function saveImage($image)
    // {
    //     $folderPath = 'products/' . now()->format('Y/m/d');
    //     $fileName = Str::random(20) . '.' . $image->getClientOriginalExtension();
    
    //     $relativePath = Storage::disk('public')->putFileAs(
    //         $folderPath,
    //         $image,
    //         $fileName
    //     );
    
    //     return $relativePath;
    // }
}
