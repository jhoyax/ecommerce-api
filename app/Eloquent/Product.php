<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Product extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'price', 'stock', 'discount',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'price' => 0,
        'stock' => 0,
        'discount' => 0,
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
     * Get all categories of the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(ProductCategory::class)->latest('updated_at');
    }
}
