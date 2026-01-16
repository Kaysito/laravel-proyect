<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController; // Importamos tu nuevo controlador

// Ruta Principal (Usa la función 'index' del controlador)
Route::get('/', [CaptchaController::class, 'index']);

// Ruta Post (Usa la función 'store' del controlador)
Route::post('/guardar-click', [CaptchaController::class, 'store']);

// Ruta de Error 404 (Fallback)
Route::fallback(function () {
    return view('404');
});