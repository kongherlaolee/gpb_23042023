<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Drink;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class DrinkApiController extends Controller
{
    public function get(){
        return response([
            'data' => Drink::get()
        ],200);
    }
    public function add(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:drinks',
                    'buy_price' => 'required',
                    'sale_price' => 'required',
                    'qty' => 'required',
                    'unit' => 'required',
                    'image' => 'required|mimes:jpg,png,jpeg,jfif'
            ], [
                    'name.required' => 'ໃສ່ຊື່ເຄື່ອງດື່ມກ່ອນ!',
                    'name.unique' => 'ຊື່ເຄື່ອງດື່ມນີ້ມີໃນລະບົບແລ້ວ',
                    'buy_price.required' => 'ໃສ່ລາຄາຂາຍກ່ອນ',
                    'qty.required' => 'ໃສ່ຈໍານວນກ່ອນ',
                    'unit.required' => 'ໃສ່ຫົວໜ່ວຍກ່ອນ',
                    'image.required' => 'ເລືອກຮູບເຄື່ອງດື່ມ!',
                ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                    $data = new Drink();
                    $data->name  = $request->name;
                    $data->buy_price  = $request->buy_price;
                    $data->sale_price  = $request->sale_price;
                    $data->qty  = $request->qty;
                    $data->unit  = $request->unit;
                    $imageName = Carbon::now()->timestamp.'.'.$request->image->extension();
                    $request->image->storeAs('upload/drink', $imageName);
                    $data->image = "upload/drink/$imageName";
                    $data->save();
                return response()->json(['status' => 'true', 'message' => "ບັນທຶກຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function update(Request $request)
    {
        try{
                $data = Drink::find($request->id);
                if(!$data){
                   return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                   ], 405);
                }
                $data->name  = $request->name;
                $data->buy_price  = $request->buy_price;
                $data->sale_price  = $request->sale_price;
                $data->qty  = $request->qty;
                $data->unit = $request->unit;
                if($request->image) {
                    if ($request->image != $data->image) {
                        if (file_exists($data->image)) {
                            unlink($data->image);
                            $data->delete();
                        }
                    }
                    $imageName = Carbon::now()->timestamp.'.'.$request->image->extension();
                    $request->image->storeAs('upload/drink', $imageName);
                    $data->image = "upload/drink/$imageName";
                }
                $data->save();
                    return response()->json(['status' => 'true', 'message' => "ແກ້ໄຂຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function delete($id)
    {
        try {
            $data = Drink::find($id);
            if(!$data){
                return response([
                 'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
             }
            if (file_exists($data->image)) {
                unlink($data->image);
                $data->delete();
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
            $data = Drink::find($id);
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