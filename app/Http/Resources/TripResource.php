<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
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
            'start' => $this->resource->start,
            'finish' => $this->resource->finish,
            'car_name' => $this->resource->car_name,
            'total_cost' => $this->resource->total_cost,
        ];
    }
}
