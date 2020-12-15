<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'category_id' => $this->category_id ,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'quantity_available' => $this->quantity_available ;
            'in_stock' => $this->in_stock,
            'status' => $this->status ,
        ];
    }
}
