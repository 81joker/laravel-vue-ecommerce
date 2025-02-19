<?php

namespace App\Models;

use App\Models\Payment;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'status', 'created_by', 'updated_by'];


    public function isPaid() {
        return $this->status === OrderStatus::Paid->value ;
    }

    public function payment(){
        return $this->hasOne(Payment::class );
    }

    public function  items(){
        return $this->hasMany(OrderItem::class);
    }
}
