<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Storage;

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
Route::get('films', [FilmController::class, 'index']);
Route::get('films/pages', [FilmController::class, 'pagination']);

Route::get('halls', [HallController::class, 'index']);
Route::get('seances', [SeanceController::class, 'index']);
Route::get('tickets/{seance}/{date}', [TicketController::class, 'show']);
Route::post('tickets', [TicketController::class, 'store']);

// ** Public file route **//
Route::get('files/{fileName}', [FileController::class, 'loadFile']);

// Admin routes
Route::post('/token/create', [ApiTokenController::class, 'createToken']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('/token/clear', [ApiTokenController::class, 'clearToken']);

    Route::post('films', [FilmController::class, 'store']);
    Route::delete('films/{id}', [FilmController::class, 'destroy']);

    Route::post('halls', [HallController::class, 'store']);
    Route::put('halls/{id}', [HallController::class, 'update']);
    Route::delete('halls/{id}', [HallController::class, 'destroy']);

    Route::post('seances', [SeanceController::class, 'store']);
    Route::delete('seances/{id}', [SeanceController::class, 'destroy']);
});


