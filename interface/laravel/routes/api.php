<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RasaController;
use Illuminate\Support\Facades\Log;

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

Route::middleware('api')->group(function () {
    /*
        NHTSA API used for populating drop-downs and data in:
            /interface/laravel/resources/js/Pages/Tools/CarData.vue
        This route utilizes the NHTSA controller found at:
            /interface/laravel/app/Http/Controllers/NHTSA.php
            For more information on how the functions in that controller work view that file
        This route takes just a base URL and query parameters
        The 'options' query parameter is required for the switch to determine which function to call
        The original request parameter is returned so the request handler on the other end knows where to put the data
        Requests that take an 'id' parameter are using the eloquent model ID
        To reduce load on the DB, some requests include string data from other models already accessed.
    */

    Route::post('/rasa', function (Request $request) {
        return array (
            'response' => RasaController::askJarvis($request['message'])
        );
    });
});