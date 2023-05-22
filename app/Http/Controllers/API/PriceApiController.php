<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Price;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class PriceApiController extends Controller
{
    public function get(){
        return response([
            'data' => Price::get()
        ],200);
    }
    public function get_price_customer(){
        return response([
            'data' => Price::select('prices.*', 'sd.number','sd.detail')->join('stadiums as sd', 'sd.id', '=', 'prices.stadium_id')->get()
        ],200);
    }
    public function get_price_customer_by_id($id){
        return response([
            'data' => Price::where('stadium_id', $id)->get()
        ],200);
    }
    public function add(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'time' => 'required',
                    'price' => 'required|numeric',
                    'stadium_id' => 'required',
               ],[
                 'time.required' => 'ໃສ່ເວລາກ່ອນ',
                //  'time.unique' => 'ເວລານີ້ມີໃນລະບົບແລ້ວ',
                 'price.required' => 'ໃສ່ລາຄາກ່ອນ',
                 'stadium_id.required' => 'ເລືອກເດີ່ນກ່ອນ',
               ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                    $check = Price::where('time', $request->time)->where('stadium_id', $request->stadium_id)->first();
                    if($check){
                        return response()->json([
                            'message' => 'ເວລາຕໍາກັນ'
                        ], 422);
                        return;
                    }
                    $data = new Price();
                    $data->time  = $request->time;
                    $data->price  = $request->price;
                    $data->stadium_id  = $request->stadium_id;
                    $data->save();
                return response()->json(['status' => 'true', 'message' => "ບັນທຶກຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try{
                $data = Price::find($id);
                if(!$data){
                   return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                   ], 405);
                }
                $data->time  = $request->time;
                $data->price  = $request->price;
                $data->stadium_id  = $request->stadium_id;
                $data->update();
                    return response()->json(['status' => 'true', 'message' => "ແກ້ໄຂຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function delete($id)
    {
        try {
            $data = Price::find($id);
            if(!$data){
                return response([
                 'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
             }
            $data->delete();
                return response()->json(['status' => 'true', 'message' => "ລຶບຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function get_by_id($id)
    {
        try {
            $data = Price::find($id);
            if(!$data){
                return response([
                 'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
             }
                return response()->json(['status' => 'true', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
}