<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;

// 1. LA PUERTA (Login con Captcha)
Route::get('/', [CaptchaController::class, 'showLogin'])->name('login');
Route::post('/verificar-acceso', [CaptchaController::class, 'verifyLogin']);

// 2. EL DASHBOARD (Home)
Route::get('/home', [DashboardController::class, 'index'])->name('home');

// 3. SECCIÓN CALCULADORA
Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

// 4. SECCIÓN CLICKER
Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

// 5. SECCIÓN CARRUSEL (Galería)
Route::get('/carrusel', [DashboardController::class, 'carrusel'])->name('carrusel');
Route::post('/carrusel/subir', [DashboardController::class, 'subirFoto'])->name('carrusel.subir');
// Ruta DELETE para borrar fotos individualmente
Route::delete('/carrusel/eliminar/{id}', [DashboardController::class, 'eliminarFoto'])->name('carrusel.eliminar');

// 6. SECCIÓN ERROR (Demo)
Route::get('/error-demo', [DashboardController::class, 'errorDemo'])->name('error.demo');

// 7. SECCIÓN FORMULARIO
Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');

// Fallback
Route::fallback(function () {
    return redirect('/');
});
