<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/me', [AuthController::class, 'me']);
    });
});

Route::group(['middleware' => ['api', 'jwt.verify']], function () {
    Route::group(['prefix'=>'products'], function (){
        Route::get('/', [ApiController::class, 'products']);
        Route::post('create', [ApiController::class, 'create']);
    });


    Route::post('save-card', [ApiController::class, 'save_to_card']);
    Route::post('pay', [ApiController::class, 'pay']);
    Route::post('search', [ApiController::class, 'search']);
});
