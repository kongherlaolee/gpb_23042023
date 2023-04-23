<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class CustomerApiController extends Controller
{
    public function get(){
        return response([
            'data' => Customer::get()
        ],200);
    }
    public function add(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'username' => 'required',
                    'tel' => 'required|unique:customers',
                    'address' => 'required',
                    'password' => 'required'
            ], [
                    'name.required' => 'ໃສ່ຊື່ກ່ອນ!',
                    'username.required' => 'ໃສ່ຊື່ຜູ້ໃຊ້ກ່ອນ!',
                    'tel.required' => 'ໃສ່ເບີໂທກ່ອນ',
                    'address.required' => 'ໃສ່ທີ່ຢຸ່ກ່ອນ',
                    'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ',
                    'tel.unique' => 'ເບີ້ນີ້ມີໃນລະບົບແລ້ວ',
                ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                    $data = new Customer();
                    $data->name  = $request->name;
                    $data->username  = $request->username;
                    $data->tel  = $request->tel;
                    $data->address  = $request->address;
                    $data->password =  bcrypt($request->password);
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
                $data = Customer::find($id);
                if(!$data){
                   return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                   ], 405);
                }
                $data->name  = $request->name;
                $data->username  = $request->username;
                $data->tel  = $request->tel;
                $data->address  = $request->address;
                if(!empty($request->password)){
                    $data->password =  bcrypt($request->password);
                }
                $data->update();
                    return response()->json(['status' => 'true', 'message' => "ແກ້ໄຂຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $request->all(), 'data' => []], 500);
        }
    }
    public function delete($id)
    {
        try {
            $data = Customer::find($id);
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
    public function login(Request $request)
    {
            try {
                $validator = Validator::make($request->all(), [
                    'username' => 'required',
                    'password' => 'required|min:6'
            ], [
                'username.required' => 'ໃສ່ຊື່ຜູ້ໃຊ້ກ່ອນ!',
                'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ!',
                ]);
            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                        if (Auth::guard('webcustomer')->attempt($request->all())) {
                                    return response([
                                        'data' => auth()->guard('webcustomer')->user(),
                                        'token' => auth()->guard('webcustomer')->user()->createToken('secret')->plainTextToken
                                    ], 200);
                        } else {
                            return response([
                                'message' => 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ!'
                            ], 403);
                        }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function getProfile(){
        $data = Customer::find(auth()->user()->id);
        if(!$data){
            return response()->json([
                'data' => 'Not found'
            ], 405);
        }
        return response([
            'data' => $data
        ],200);
    }
    public function logout() 
    {
        $user = auth()->user();
        if ($user instanceof User) {
            $user->tokens()->delete();
        }
        return response([
            'message' => 'ອອກລະບົບສຳເລັດ!'
        ], 200);
    }
}