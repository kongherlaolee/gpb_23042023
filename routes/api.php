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
    Route::put('update_stadium/{id}',[App\Http\Controllers\API\StadiumApiController::class, 'update']);
    Route::delete('delete_stadium/{id}',[App\Http\Controllers\API\StadiumApiController::class, 'delete']);

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

});
//login employee
Route::post('login', [App\Http\Controllers\API\EmployeeApiController::class, 'login']);
//customer
Route::post('add_customer', [App\Http\Controllers\API\CustomerApiController::class, 'add']);
Route::post('login_customer', [App\Http\Controllers\API\CustomerApiController::class, 'login']);