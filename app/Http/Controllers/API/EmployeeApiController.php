<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class EmployeeApiController extends Controller
{
    public function get(){
        return response([
            'data' => Employee::get()
        ],200);
    }
    public function add(Request $request)
    {
        try {
                $validator = Validator::make($request->all(), [
                    'fullname' => 'required',
                    'gender' => 'required',
                    'phone' => 'required|unique:employees',
                    'address' => 'required',
                    'password' => 'required'
            ], [
                    'fullname.required' => 'ໃສ່ຊື່ກ່ອນ!',
                    'gender.required' => 'ເລືອກເພດກ່ອນ!',
                    'phone.required' => 'ໃສ່ເບີໂທກ່ອນ',
                    'address.required' => 'ໃສ່ທີ່ຢຸ່ກ່ອນ',
                    'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ',
                    'phone.unique' => 'ເບີ້ນີ້ມີໃນລະບົບແລ້ວ',
                ]);

            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                    $data = new Employee();
                    $data->fullname  = $request->fullname;
                    $data->gender  = $request->gender;
                    $data->phone  = $request->phone;
                    $data->email  = $request->email;
                    $data->address  = $request->address;
                    $data->password =  bcrypt($request->password);
                    $data->role = $request->role;
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
                $data = Employee::find($id);
                if(!$data){
                   return response([
                    'data' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!'
                   ], 405);
                }
                $data->fullname  = $request->fullname;
                $data->gender  = $request->gender;
                $data->phone  = $request->phone;
                $data->email  = $request->email;
                $data->address  = $request->address;
                if(!empty($request->password)){
                    $data->password =  bcrypt($request->password);
                }
                $data->role = $request->role;
                $data->update();
                    return response()->json(['status' => 'true', 'message' => "ແກ້ໄຂຂໍ້ມູນສໍາເລັດແລ້ວ", 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'false', 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }
    public function delete($id)
    {
        try {
            $data = Employee::find($id);
            if(!$data){
                return response([
                 'data' => 'ລະຫັດນີ້ບໍ່ມີໃນລະບົບ!'
                ], 405);
             }
             $data->status = 0;
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
                    'phone' => 'required',
                    'password' => 'required|min:6'
            ], [
                'phone.required' => 'ໃສ່ເບີ້ໂທລະສັບກ່ອນ!',
                'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ!',
                ]);
            if ($validator->fails()) {
                $error = $validator->errors()->all()[0];
                return response()->json(['status' => 'false', 'message' => $error, 'data' => []], 422);
            } else {
                        if (Auth::guard('webemployee')->attempt($request->all())) {
                                    return response([
                                        'data' => auth()->guard('webemployee')->user(),
                                        'token' => auth()->guard('webemployee')->user()->createToken('secret')->plainTextToken
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
        $data = Employee::find(auth()->user()->id);
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
        if ($user instanceof Employee) {
            $user->tokens()->delete();
        }
        return response([
            'message' => 'ອອກລະບົບສຳເລັດ!'
        ], 200);
    }
}