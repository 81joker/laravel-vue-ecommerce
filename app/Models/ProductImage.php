<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'url',
        'mime',
        'size',
        'position',
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
