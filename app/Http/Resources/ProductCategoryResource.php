<?php

namespace App\Http\Resources;

use App\Eloquent\ProductCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $children = $this->children;
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'created_at' => $this->created_at->toDateString(),
            'updated_at' => $this->updated_at->toDateString(),
            'image' => [
                'name' => $this->getFirstMedia('images')->file_name ?? '',
                'url' => $this->getFirstMedia('images') ? $this->getFirstMedia('images')->getFullUrl() : '',
            ],
            'children' => ProductCategory::getChildren($this),
            'totalProduct' => ProductCategory::getTotalProducts($this),
        ];
    }
}
