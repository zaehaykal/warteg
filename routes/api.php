<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PesananController;
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

Route::get('/pengguna', [PenggunaController::class, 'index']);
Route::get('/pengguna/{id}', [PenggunaController::class, 'show']);
Route::post('/pengguna', [PenggunaController::class, 'store']);
Route::post('/pengguna/update/{id}', [PenggunaController::class, 'update']);

Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::post('/admins', [AdminController::class, 'store']);
Route::post('/admins/update/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);


Route::prefix('pesanan')->group(function () {
    Route::get('/', [PesananController::class, 'index']); // GET all pesanan
    Route::post('/', [PesananController::class, 'store']); // POST create new pesanan
    Route::get('/{id}', [PesananController::class, 'show']); // GET pesanan by ID
    Route::delete('/{id}', [PesananController::class, 'destroy']); // DELETE pesanan by ID

    // Nested routes for subpesanan under pesanan
    Route::prefix('{pesanan_id}/subpesanan')->group(function () {
        Route::get('/', [SubpesananController::class, 'index']); // GET all subpesanan for a pesanan
        Route::post('/', [SubpesananController::class, 'store']); // POST create new subpesanan
        Route::get('/{id}', [SubpesananController::class, 'show']); // GET subpesanan by ID
        Route::delete('/{id}', [SubpesananController::class, 'destroy']); // DELETE subpesanan by ID
    });
});
