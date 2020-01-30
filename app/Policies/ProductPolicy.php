<?php

namespace App\Policies;

use App\Eloquent\User;
use App\Eloquent\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\Eloquent\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create products');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Eloquent\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        return $user->hasPermissionTo('edit products');
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Eloquent\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        return $user->hasPermissionTo('delete products');
    }
}
