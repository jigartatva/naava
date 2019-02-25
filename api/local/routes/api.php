<?php

use Illuminate\Http\Request;

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
Route::resource('customers','Api\Customers\CustomerController');
Route::resource('maintainers','Api\Maintainers\MaintainerContactsController');
Route::resource('wallgroups','Api\Groups\WallGroupController');
// Route::get('/test',function(){
// 	return response()->json(['status'=>true,'message'=>'Working...']);
// });

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
