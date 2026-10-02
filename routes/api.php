<?php
use App\Http\Controllers\API\TicketController;

Route::get('/tickets/{id}', [TicketController::class, 'show']);