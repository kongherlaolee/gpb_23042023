<?php

namespace App\Http\Resources\SaleDrink;

use App\Models\Employee;
use App\Models\SaleDrinkDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBillResource extends JsonResource
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
           'id' => $this->order_id,
           'receive_name' => $this->receive_name,
           'total' => $this->total,
           'emp_id' => $this->emp_id,
           'created_at' => $this->created_at,
           'employee' => Employee::find($this->emp_id),
           'item' => SaleDrinkDetail::where('order_id', $this->order_id)->get()
        ];
    }
}
