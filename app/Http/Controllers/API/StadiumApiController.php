<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Stadium;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class StadiumApiController extends Controller
{
    public function get()
    {
        return response([
            'data' => Stadium::orderBy('id', 'desc')->get()
        ], 200);
    }
    public function get_customer_stadium()
    {
        return response([
            'data' => Stadium::orderBy('id', 'desc')->get()
        ], 200);
    }
    public function get_stadium_customer_byId($id)
    {
        return response([
            'data' => Stadium::where('id', $id)->get()
        ], 200);
    }
    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'number' => 'required|unique:stadiums',
                'detail' => 'required',
                'image' => 'required'
            ], [
                'number.required' => 'ໃສ່ເບີເດີ່ກ່ອນ!',
                'number.unique' => 'ເບີເດີ່ນີ້ມີໃນລະບົບແລ້ວ',
                'detail.required' => 'ໃສ່ລາຍລະອຽດກ່ອນ',
                'image.required' => 'ເລືອກຮູບເດີ່ນກ່ອນ',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                $data = new Stadium();
                $data->number  = $request->number;
                $data->detail  = $request->detail;
                $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
                $request->image->storeAs('upload/stadium', $imageName);
                $data->image = "upload/stadium/$imageName";
                $data->save();
                return response()->json(['status' => 'true', 'message' => "ບັນທຶກຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function update(Request $request)
    {
        try {
            $data = Stadium::find($request->id);
            if (!$data) {
                return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
            }
            $data->number  = $request->number;
            $data->detail  = $request->detail;
            if ($request->image) {
                $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
                $request->image->storeAs('upload/stadium', $imageName);
                $data->image = "upload/stadium/$imageName";
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
            $data = Stadium::find($id);
            if (!$data) {
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
            $data = Stadium::find($id);
            if (!$data) {
                return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
            }
            return response()->json(['status' => 'true', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function update_date_not_empty(Request $request, $id){
        try{
         $data = Stadium::find($id);
         if($data){
             $data->date_not_empty = $request->date_not_empty;
             $data->update();
             return response()->json(['message' => 'ແກ້ໄຂວັນທີບໍ່ຫວ່າງສໍາເລັດແລ້ວ'], 200);
         }
        }catch(\Exception $ex){
            return response()->json(['message' =>  $ex->getMessage()], 500);
        }
    }
}
