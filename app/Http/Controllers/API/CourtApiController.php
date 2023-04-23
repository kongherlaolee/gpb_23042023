<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Court;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class CourtApiController extends Controller
{
    public function get(){
        return response([
            'data' => Court::get()
        ],200);
    }
    public function add(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'court_num' => 'required|unique:courts',
                    'court_detail' => 'required',
            ], [
                    'court_num.required' => 'ໃສ່ເບີເດີ່ກ່ອນ!',
                    'court_num.unique' => 'ເບີເດີ່ນີ້ມີໃນລະບົບແລ້ວ',
                    'court_detail.unique' => 'ໃສ່ລາຍລະອຽດກ່ອນ',
                ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                    $data = new Court();
                    $data->court_num  = $request->court_num;
                    $data->court_detail  = $request->court_detail;
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
                $data = Court::find($id);
                if(!$data){
                   return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                   ], 405);
                }
                $data->court_num  = $request->court_num;
                $data->court_detail  = $request->court_detail;
                $data->update();
                    return response()->json(['status' => 'true', 'message' => "ແກ້ໄຂຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function delete($id)
    {
        try {
            $data = Court::find($id);
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
            $data = Court::find($id);
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