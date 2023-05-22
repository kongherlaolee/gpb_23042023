<?php

namespace App\Http\Resources\Stadium;

use App\Models\Price;
use App\Models\Stadium;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailStadiumResource extends JsonResource
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
             "id" => $this->id,
             "price" => $this->price,
             "stadium_id" => $this->stadium_id,
             "time" => $this->time,
             'stadium' => Stadium::where('id', $this->stadium_id)->first()
        ];
    }
}
