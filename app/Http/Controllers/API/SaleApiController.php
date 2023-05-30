<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleDrink\OrderBillResource;
use App\Models\SaleDrink;
use App\Models\SaleDrinkDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleApiController extends Controller
{
    public function sale_drink(Request $request)
    {
        try {
            $sale = new SaleDrink();
            $sale->emp_id = auth()->user()->id;
            if($request->receive_name){
               $sale->receive_name = $request->receive_name;
            }
            $sale->total = $request->total;
            $sale->recieve_money = $request->recieve_money;
            $sale->change = $request->change;
            $sale->save();
            $items = $request->input('items');
            if (is_array($items)) {
                foreach($items as $item) {
                    $data = new SaleDrinkDetail();
                    $data->order_id = $sale->order_id;
                    $data->d_id  = $item['d_id'];
                    $data->qty  = $item['qty'];
                    $data->price  = $item['price'];
                    $data->total  = $item['total'];
                    $data->save();
                }
            } else {
                DB::rollBack();
                return response()->json(["message" => "ບໍ່ມີຂໍ້ມູນອໍເດີ້ຍ່ອຍ",], 401);
            }
            return response()->json([
                'data' => OrderBillResource::collection(SaleDrink::where('order_id', $sale->order_id)->get())
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }
    public function report_sale_drinks(){
        return response(['data' => OrderBillResource::collection(SaleDrink::get())], 200);
    }
}
