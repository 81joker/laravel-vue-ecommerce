<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = ['total_price', 'status', 'created_by', 'updated_by'];


    public function isPaid() {
        return $this->status === OrderStatus::Paid->value ;
    }
}
