<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:sanctum']], function() {
    //employees
    Route::post('add_employee', [App\Http\Controllers\API\EmployeeApiController::class, 'add']);
    Route::get('get_employee',[App\Http\Controllers\API\EmployeeApiController::class, 'get']);
    Route::put('update_employee/{id}',[App\Http\Controllers\API\EmployeeApiController::class, 'update']);
    Route::delete('delete_employee/{id}',[App\Http\Controllers\API\EmployeeApiController::class, 'delete']);
    Route::get('get_employee_profile', [App\Http\Controllers\API\EmployeeApiController::class, 'getProfile']);
    //customers
    Route::get('get_customer_profile', [App\Http\Controllers\API\CustomerApiController::class, 'getProfile']);
    Route::get('get_customer',[App\Http\Controllers\API\CustomerApiController::class, 'get']);
    Route::put('update_customer/{id}',[App\Http\Controllers\API\CustomerApiController::class, 'update']);
    Route::delete('delete_customer/{id}',[App\Http\Controllers\API\CustomerApiController::class, 'delete']);

    //stadium
    Route::get('get_stadium_by_id/{id}', [App\Http\Controllers\API\StadiumApiController::class, 'get_by_id']);
    Route::post('add_stadium',[App\Http\Controllers\API\StadiumApiController::class, 'add']);
    Route::get('get_stadium',[App\Http\Controllers\API\StadiumApiController::class, 'get']);
    Route::post('update_stadium',[App\Http\Controllers\API\StadiumApiController::class, 'update']);
    Route::delete('delete_stadium/{id}',[App\Http\Controllers\API\StadiumApiController::class, 'delete']);
    Route::put('update_date_not_empty/{id}', [App\Http\Controllers\API\StadiumApiController::class, 'update_date_not_empty']);

    //drinks
    Route::get('get_drink_by_id/{id}', [App\Http\Controllers\API\DrinkApiController::class, 'get_by_id']);
    Route::post('add_drink',[App\Http\Controllers\API\DrinkApiController::class, 'add']);
    Route::get('get_drink',[App\Http\Controllers\API\DrinkApiController::class, 'get']);
    Route::post('update_drink',[App\Http\Controllers\API\DrinkApiController::class, 'update']);
    Route::delete('delete_drink/{id}',[App\Http\Controllers\API\DrinkApiController::class, 'delete']);
     //prices
     Route::get('get_price_by_id/{id}', [App\Http\Controllers\API\PriceApiController::class, 'get_by_id']);
     Route::post('add_price',[App\Http\Controllers\API\PriceApiController::class, 'add']);
     Route::get('get_price',[App\Http\Controllers\API\PriceApiController::class, 'get']);
     Route::put('update_price/{id}',[App\Http\Controllers\API\PriceApiController::class, 'update']);
     Route::delete('delete_price/{id}',[App\Http\Controllers\API\PriceApiController::class, 'delete']);
     //sale drinks 
     Route::post('sale_drink',[App\Http\Controllers\API\SaleApiController::class, 'sale_drink']);
     Route::get('report_sale_drinks',[App\Http\Controllers\API\SaleApiController::class, 'report_sale_drinks']);
     //booking
     Route::post('booking',[App\Http\Controllers\API\BookingApiController::class, 'booking']);
     Route::get('get_all_bookings',[App\Http\Controllers\API\BookingApiController::class, 'get_all_bookings']);
     Route::put('confirm_booking/{id}',[App\Http\Controllers\API\BookingApiController::class, 'confirm_booking']);
     Route::put('cancel_booking/{id}',[App\Http\Controllers\API\BookingApiController::class, 'cancel_booking']);
     Route::get('report_bookings',[App\Http\Controllers\API\BookingApiController::class, 'report_bookings']);
});
Route::get('get_bookings/{date}',[App\Http\Controllers\API\BookingApiController::class, 'get_bookings']);
//login employee
Route::post('login', [App\Http\Controllers\API\EmployeeApiController::class, 'login']);
//customer
Route::post('register_customer', [App\Http\Controllers\API\CustomerApiController::class, 'add']);
Route::post('login_customer', [App\Http\Controllers\API\CustomerApiController::class, 'login']);
Route::get('get_stadium_customer',[App\Http\Controllers\API\StadiumApiController::class, 'get_customer_stadium']);
Route::get('get_stadium_customer_byId/{id}',[App\Http\Controllers\API\StadiumApiController::class, 'get_stadium_customer_byId']);
Route::get('get_price_customer',[App\Http\Controllers\API\PriceApiController::class, 'get_price_customer']);
Route::get('get_price_customer_by_id/{id}',[App\Http\Controllers\API\PriceApiController::class, 'get_price_customer_by_id']);

