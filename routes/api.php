<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DepartemenTujuanController;
use App\Http\Controllers\API\KategoriKendalaController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\TicketReplyController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/kategori-kendala', [KategoriKendalaController::class, 'index']);
Route::get('/departemen-tujuan', [DepartemenTujuanController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/tickets', [TicketController::class, 'index']);
    Route::post('/tickets', [TicketController::class, 'store']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    Route::put('/tickets/{id}', [TicketController::class, 'update']);
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy']);

    Route::post('/tickets/{ticketId}/replies', [TicketReplyController::class, 'store']);

    Route::middleware('role:admin')->group(function () {
        Route::post('/kategori-kendala', [KategoriKendalaController::class, 'store']);
        Route::delete('/kategori-kendala/{id}', [KategoriKendalaController::class, 'destroy']);

        Route::post('/departemen-tujuan', [DepartemenTujuanController::class, 'store']);
        Route::delete('/departemen-tujuan/{id}', [DepartemenTujuanController::class, 'destroy']);
    });
});
