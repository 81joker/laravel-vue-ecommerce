<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasSlug;
    use SoftDeletes;
    use HasFactory;
    use HasApiTokens;
    protected $fillable = ['title' , 'slug' , 'image' , 'image_mime' , 'image_size' , 'description' , 'price' , 'created_by' , 'updated_by' , 'deleted_by'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
