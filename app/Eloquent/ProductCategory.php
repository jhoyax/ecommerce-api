<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
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

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function childrenProductCategories()
    {
        return $this->hasMany(ProductCategory::class)->with('productCategories');
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
}
