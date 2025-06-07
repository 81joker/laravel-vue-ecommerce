<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use SoftDeletes;
    use HasSlug;
    use HasFactory;

    protected $fillable = ['name', 'slug', 'active', 'parent_id', 'created_by', 'updated_by', 'deleted_by'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
