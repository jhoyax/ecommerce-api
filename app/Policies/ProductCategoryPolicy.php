<?php

namespace App\Policies;

use App\Eloquent\User;
use App\Eloquent\ProductCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create product categories.
     *
     * @param  \App\Eloquent\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create product categories');
    }

    /**
     * Determine whether the user can update the product category.
     *
     * @param  \App\Eloquent\User  $user
     * @param  \App\Eloquent\ProductCategory  $productCategory
     * @return mixed
     */
    public function update(User $user, ProductCategory $productCategory)
    {
        return $user->hasPermissionTo('edit product categories');
    }

    /**
     * Determine whether the user can delete the product category.
     *
     * @param  \App\Eloquent\User  $user
     * @param  \App\Eloquent\ProductCategory  $productCategory
     * @return mixed
     */
    public function delete(User $user, ProductCategory $productCategory)
    {
        return $user->hasPermissionTo('delete product categories');
    }
}
