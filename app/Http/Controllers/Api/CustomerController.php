<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Models\Api\User;
use App\Models\Customer;
use App\Enums\AddressType;
use App\Enums\CustomerStatus;
use App\Models\CustomerAddress;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerListResource;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
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

        $query = Customer::query()->with('user')
        ->orderBy("customers.$sortField", $sortDirection);
        if ($search) {
            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->orWhere('users.email', 'like', "%{$search}%")
            ->orWhere('customers.phone', 'like', "%{$search}%");
    
        }
        $paginator = $query->paginate($perPage);
        return CustomerListResource::collection($paginator);
    }



     /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }
      /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer     $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customerData = $request->validated();
        //@todo Nehad user_id instead of updated_by
        $customerData['updated_by'] = $request->user()->id;
        $customerData['status'] = $customerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
        $shippingData = $customerData['shippingAddress'];
        $billingData = $customerData['billingAddress'];

        $customer->update($customerData);

        if ($customer->shippingAddress) {
            $customer->shippingAddress->update($shippingData);
        } else {
            $shippingData['customer_id'] = $customer->user_id;
            $shippingData['type'] = AddressType::Shipping->value;
            CustomerAddress::create($shippingData);
        }
        if ($customer->billingAddress) {
            $customer->billingAddress->update($billingData);
        } else {
            $billingData['customer_id'] = $customer->user_id;
            $billingData['type'] = AddressType::Billing->value;
            CustomerAddress::create($billingData);
        }

        return new CustomerResource($customer);
        // DB::beginTransaction();
        // try {
        //     $customer->update($customerData);

        //     if ($customer->shippingAddress) {
        //         $customer->shippingAddress->update($shippingData);
        //     } else {
        //         $shippingData['customer_id'] = $customer->user_id;
        //         $shippingData['type'] = AddressType::Shipping->value;
        //         CustomerAddress::create($shippingData);
        //     }

        //     if ($customer->billingAddress) {
        //         $customer->billingAddress->update($billingData);
        //     } else {
        //         $billingData['customer_id'] = $customer->user_id;
        //         $billingData['type'] = AddressType::Billing->value;
        //         CustomerAddress::create($billingData);
        //     }
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     Log::critical(__METHOD__ . ' method does not work. '. $e->getMessage());
        //     throw $e;
        // }

        // DB::commit();

        // return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
         $customer->delete();
         return response()->noContent();
    }
    public function countries()
    {
        return CountryResource::collection(Country::query()->orderBy('name', 'asc')->get());
    }
}
