<?php

namespace App\Http\Controllers\API;

use App\Eloquent\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGenerateSlugRequest;

class ProductGenerateSlugController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProductGenerateSlugRequest $request)
    {
        return [
            'slug' => Product::generateSlug($request->input('title')),
        ];
    }
}
