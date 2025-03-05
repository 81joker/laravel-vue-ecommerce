<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Customer;
use App\Enums\OrderStatus;
use App\Models\Api\Product;
use Illuminate\Http\Request;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Enums\AddressType;

class DashboardController extends Controller
{
    public function activeCustomers () {
       return  Customer::where('status', CustomerStatus::Active->value)->count();
    //    return  Customer::where('status', operator: operator: 1)->count();
    }
    public function activeProducts () {
        // TODO: Implement where for product active status
       return  Product::count();
    }
    public function paidOrders () {
        return  Order::where('status', OrderStatus::Paid->value)->count();
        // return  Order::where('status', 'paid')->count();
    }

    public function totalIncome () {
        return  Order::where('status', OrderStatus::Paid->value)->sum('total_price');
    }

     // TODO: again review this method and code 
    // public function ordersByCountry()
    // {
    //     $fromDate = $this->getFromDate();
    //     $query = Order::query()
    //         ->select(['c.name', DB::raw('count(orders.id) as count')])
    //         ->join('users', 'created_by', '=', 'users.id')
    //         ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
    //         ->join('countries AS c', 'a.country_code', '=', 'c.code')
    //         ->where('status', OrderStatus::Paid->value)
    //         ->where('a.type', AddressType::Billing->value)
    //         ->groupBy('c.name')
    //         ;

    //     if ($fromDate) {
    //         $query->where('orders.created_at', '>', $fromDate);
    //     }

    //     return $query->get();
    // }

    public function latestCustomers() {
        return Customer::query()
        // TODO: Revview join table
        ->select(['first_name' , 'last_name' , 'u.email'])
        ->join('users AS u' , 'customers.user_id' , '=', 'u.id')
        ->where('status' , CustomerStatus::Active->value)
        ->orderBy('created_at' , 'desc')->limit(5)->get();  
    }
}
