<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController; // ¡Crearemos este controlador nuevo!

// 1. LA PUERTA (Login con Captcha)
Route::get('/', [CaptchaController::class, 'showLogin'])->name('login');
Route::post('/verificar-acceso', [CaptchaController::class, 'verifyLogin']);

// 2. EL DASHBOARD (Home)
Route::get('/home', [DashboardController::class, 'index'])->name('home');

// 3. SECCIÓN CALCULADORA
Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

// 4. SECCIÓN CLICKER (Guardar en BD)
Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

// Fallback
Route::fallback(function () {
    return redirect('/');
});