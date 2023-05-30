<?php

namespace App\Http\Resources\Booking;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Price;
use App\Models\Stadium;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id' => $this->id,
            'date_booking' => $this->date_booking,   
            'cus_id' => $this->cus_id,
            'price_id' => $this->price_id,
            'total' => $this->total,
            'pay_percent' => $this->pay_percent,
            'status' => $this->status,
            'slip_payment' => $this->slip_payment,
            'emp_id' => $this->emp_id,
            'created_at' => $this->created_at,
            'customer' => Customer::find($this->cus_id),
            'price' => Price::select('prices.*','sd.number','sd.detail')->join('stadiums as sd', 'sd.id', '=', 'prices.stadium_id')->where('prices.id', $this->price_id)->get(),
            'employee' => Employee::where('id', $this->emp_id)->get()
        ];
    }
}
