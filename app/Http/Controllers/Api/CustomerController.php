<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\User;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerListResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $perPage = request('per_page', 10);
        // $search = request('search', '');
        // $sortField = request('sort_field', 'updated_at');
        // $sortDirection = request('sort_direction', 'desc');
        // $query = User::query()
        //     ->where('title', 'like', "%{$search}%")
        //     ->orderBy($sortField, $sortDirection)
        //     ->paginate($perPage);

        // return CustomerListResource::collection($query);
        // return CustomerListResource::collection(User::query()->paginate(  10));

        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Customer::query()
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return CustomerListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $data = $request->validated();
        
        // $data['created_by'] = $request->user()->id;
        // $data['updated_by'] = $request->user()->id;

        $customer = Customer::create($data);
        return new CustomerListResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new CustomerListResource($user);
    }

      /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User      $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $user->update($data);

        return new CustomerListResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         $user->delete();
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
