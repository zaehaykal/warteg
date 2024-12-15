<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SubpesananController;
use App\Models\Pengguna;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/menu', [MenuController::class, 'index']);
Route::post('/menu', [MenuController::class, 'store']);
Route::get('/menu/{id}', [MenuController::class, 'show']);
Route::post('/menu/update/{id}', [MenuController::class, 'update']);
Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

Route::apiResource('promotions', PromotionController::class);


Route::prefix('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])
        ->middleware('auth:sanctum');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::post('/admins', [AdminController::class, 'store']);
Route::post('/admins/update/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

Route::prefix('pesanan')->group(function () {
    Route::post('/', [PesananController::class, 'store']);
    Route::get('/', [PesananController::class, 'index']);
    Route::get('{id}', [PesananController::class, 'show']);
    Route::delete('{id}', [PesananController::class, 'destroy']);
    Route::get('/{id}/subpesanan', [PesananController::class, 'showOrder']);
    Route::get('/subpesanan', [PesananController::class, 'showOrderMenu']);
});
