<?php


use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('jwt.auth',)->group(function(){
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/client', ClienteController::class);

});
Route::post('login', [AuthController::class, 'login'])->name('login');

