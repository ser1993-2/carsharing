<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'free' => $this->resource->free,
            'brand' => $this->resource->brand,
            'model' => $this->resource->model,
            'rate_name' => $this->resource->rate_name,
            'cost' => $this->resource->cost,
        ];
    }
}
