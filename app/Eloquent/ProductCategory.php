<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function childrenProductCategories()
    {
        return $this->hasMany(ProductCategory::class)->with('productCategories');
    }
}
