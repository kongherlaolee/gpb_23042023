<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Price;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingApiController extends Controller
{
    public function booking(Request $request)
    {
        $check_booking = Booking::where('price_id',$request->price_id)->where('status', 'booking')->first();
        if($check_booking){
            return response()->json(['message' => 'ຂໍອະໄພ ເດີ່ນນີ້ຍັງບໍ່ຫວ່າງ'], 422);
            return;
        }
        try {
            DB::beginTransaction();
            $data = new Booking();
            $data->cus_id = auth()->user()->id;
            $data->date_booking = $request->date_booking;
            $data->price_id  = $request->price_id;
            $data->total = $request->total;
            $data->pay_percent = $request->pay_percent;
            $imageName = Carbon::now()->timestamp . '.' . $request->slip_payment->extension();
            $request->slip_payment->storeAs('upload/booking', $imageName);
            $data->slip_payment = "upload/booking/$imageName";
            $data->save();
            DB::commit();
            return response()->json([
                'message' => 'ຈອງເດີ່ນສໍາເລັດແລ້ວ!',
                'data' => $data
            ], 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }
}
