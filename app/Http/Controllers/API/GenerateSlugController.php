<?php

namespace App\Http\Controllers\API;

use App\Eloquent\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateSlugRequest;

class GenerateSlugController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForProduct(GenerateSlugRequest $request)
    {
        return [
            'slug' => Product::generateSlug($request->input('title')),
        ];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createForProductCategory(GenerateSlugRequest $request)
    {
        return [
            'slug' => Product::generateSlug($request->input('title')),
        ];
    }
}
