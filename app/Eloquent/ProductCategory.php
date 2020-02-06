<?php

namespace App\Eloquent;

use App\Http\Resources\ProductCategoryResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ProductCategory extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description',
    ];

    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->slug;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all sub categories for the category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(ProductCategory::class);
    }

    /**
     * Recursive relationship
     * Get all level of sub categories for the category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Scope a query to only top parent category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTopParent($query)
    {
        return $query->whereNull('product_category_id');
    }

    /**
     * Generate title slug
     *
     * @param  string  $title
     * @return string
     */
    public static function generateSlug(string $title)
    {
        $slug = '';

        if ($title) {
            $createSlug = Str::slug($title);
            $countSlug = self::whereRaw("slug = '$createSlug' or slug LIKE '$createSlug-%'")->count();
            $slug = $createSlug . ($countSlug ? '-' . ($countSlug + 1) : '');
        }

        return $slug;
    }

    /**
     * Add a product to the category.
     *
     * @param \App\Eloquent\Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products()->attach($product);
    }

    /**
     * Get all products that belongs to the category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product')->withTimestamps();
    }

    /**
     * Get children by parent
     *
     * @param  App\Eloquent\ProductCategory  $category
     * @return array
     */
    public static function getChildren($category)
    {
        $children = [];
        foreach ($category->childrenRecursive as $childCategory) {
            $children[] = new ProductCategoryResource($childCategory);
        }

        return $children;
    }

    /**
     * Get children ids by parent
     *
     * @param  App\Eloquent\ProductCategory  $category
     * @return array
     */
    public static function getChildrenIds($category)
    {
        if ($category) {
            $childrenRecursive = $category->childrenRecursive;
            $ids = array_merge(
                [ $category->id ], // include self
                $childrenRecursive->pluck('id')->toArray()
            );
    
            foreach ($childrenRecursive as $child) {
                $ids = array_merge($ids, self::getChildrenIds($child));
            }
    
            return $ids;
        }
        
        return [];
    }

    /**
     * Get children ids by parent
     *
     * @param  App\Eloquent\ProductCategory  $category
     * @return int
     */
    public static function getTotalProducts($category)
    {
        return Product::getByCategoryIds(self::getChildrenIds($category))->count();
    }
}
