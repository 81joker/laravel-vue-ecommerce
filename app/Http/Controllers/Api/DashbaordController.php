<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Customer;
use App\Enums\OrderStatus;
use App\Models\Api\Product;
use Illuminate\Http\Request;
use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;

class DashbaordController extends Controller
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
}
