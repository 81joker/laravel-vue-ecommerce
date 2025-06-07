<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo(Category::class);
     }
    // public function children()
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public static function getActiveAsTree($resourceClassName = null){
        $categories = Category::where('active', true)->orderBy('parent_id')->get();
        return self::buildCategoryTree($categories ,null,$resourceClassName);
    }

    private static function buildCategoryTree($categories, $parentId = null ,$resourceClassName = null)
    {
        $categoryTree = [];
        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $children = self::buildCategoryTree($categories,$category->id ,$resourceClassName);
                if ($children) {
                    // $category->children = $children;
                    $category->setAttribute('children', $children);
                }
                $categoryTree[] = $resourceClassName ? new $resourceClassName($category) : $category;
            }
        }

        return $categoryTree;
    }
    // Secondary method to get active categories as a tree structure Nehad(^_^)
    // private static function buildCategoryTree(array $categories, $parentId = null)
    // {
    //     $branch = [];

    //     foreach ($categories as $category) {
    //         if ($category->parent_id == $parentId) {
    //             $children = self::buildCategoryTree($categories, $category->id);
    //             if ($children) {
    //                 $category->children = $children;
    //             }
    //             $branch[] = $category;
    //         }
    //     }

    //     return $branch;
    // }


    // public function getActiveAsTree(){
    //     return $this->where('active', true)
    //         ->with(['parent' => function ($query) {
    //             $query->select('id', 'name');
    //         }])
    //         ->get()
    //         ->map(function ($category) {
    //             return [
    //                 'id' => $category->id,
    //                 'name' => $category->name,
    //                 'slug' => $category->slug,
    //                 'parent' => $category->parent ? $category->parent->name : null,
    //             ];
    //         });
    // }
}
