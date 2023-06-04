<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booking\BookingResource;
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
        $check_booking = Booking::where('price_id', $request->price_id)->whereDate('date_booking', $request->date_booking)->first();
        if ($check_booking) {
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
    public function get_bookings($date)
    {
        return response()->json(['data' => Booking::where('status', '!=', 'cancel')->whereDate('date_booking', $date)->get()], 200);
    }
    public function get_all_bookings()
    {
        return response()->json(['data' => BookingResource::collection(Booking::where('cus_id', auth()->user()->id)->orderBy('id', 'desc')->get())], 200);
    }
    public function confirm_booking(Request $request, $id)
    {
        try {
            $data =  Booking::find($id);
            if (!$data) {
                return response()->json(['message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ'], 405);
                return;
            }
            $data->pay_percent = $request->pay_percent;
            $data->status = 'success';
            $data->update();
            return response()->json(['message' => 'ຢືນຢັນການຈອງເດີ່ນສໍາເລັດແລ້ວ'], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
    public function cancel_booking($id)
    {
        try {
            $data =  Booking::find($id);
            if (!$data) {
                return response()->json(['message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ'], 405);
                return;
            }
            $data->status = 'cancel';
            $data->update();
            return response()->json(['message' => 'ຍົກເລີກການຈອງເດີ່ນສໍາເລັດແລ້ວ'], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
    public function report_bookings(){
        return response()->json(['data' => BookingResource::collection(Booking::get())], 200);
    }
}
