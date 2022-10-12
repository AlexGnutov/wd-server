<?php

use App\Models\Ticket;
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

// ** Public routes ** //
Route::get('films', [\App\Http\Controllers\FilmController::class, 'index']);
Route::get('halls', [\App\Http\Controllers\HallController::class, 'index']);
Route::get('seances', [\App\Http\Controllers\SeanceController::class, 'index']);
Route::get('tickets/{seance}/{date}', [\App\Http\Controllers\TicketController::class, 'show']);
Route::post('tickets', [\App\Http\Controllers\TicketController::class, 'store']);

// Admin routes
Route::post('/token/create', [\App\Http\Controllers\ApiTokenController::class, 'createToken']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/token/clear', [\App\Http\Controllers\ApiTokenController::class, 'clearToken']);

    Route::post('films', [\App\Http\Controllers\FilmController::class, 'store']);
    Route::delete('films/{id}', [\App\Http\Controllers\FilmController::class, 'destroy']);

    Route::post('halls', [\App\Http\Controllers\HallController::class, 'store']);
    Route::put('halls/{id}', [\App\Http\Controllers\HallController::class, 'update']);
    Route::delete('halls/{id}', [\App\Http\Controllers\HallController::class, 'destroy']);

    Route::post('seances', [\App\Http\Controllers\SeanceController::class, 'store']);
    Route::delete('seances', [\App\Http\Controllers\SeanceController::class, 'destroy']);
});


