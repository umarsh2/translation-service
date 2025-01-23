<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

Route::get('/translations', [TranslationController::class, 'index']);
Route::post('/translations', [TranslationController::class, 'store']);
Route::put('/translations/{id}', [TranslationController::class, 'update']);
Route::delete('/translations/{id}', [TranslationController::class, 'destroy']);
Route::get('/export', [TranslationController::class, 'export']);

