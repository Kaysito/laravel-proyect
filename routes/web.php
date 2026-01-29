<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;

// 1. LOGIN
Route::get('/', [CaptchaController::class, 'showLogin'])->name('login');
Route::post('/verificar-acceso', [CaptchaController::class, 'verifyLogin']);

// 2. DASHBOARD
Route::get('/home', [DashboardController::class, 'index'])->name('home');

// 3. CALCULADORA
Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

// 4. CLICKER
Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

// 5. CARRUSEL
Route::get('/carrusel', [DashboardController::class, 'carrusel'])->name('carrusel');
Route::post('/carrusel/subir', [DashboardController::class, 'subirFoto'])->name('carrusel.subir');
Route::delete('/carrusel/eliminar/{id}', [DashboardController::class, 'eliminarFoto'])->name('carrusel.eliminar');

// 6. ERROR DEMO → 500 simulado, sin usar sesión ni DB
Route::get('/error-demo', [DashboardController::class, 'errorDemo'])
    ->name('error.demo')
    ->withoutMiddleware([StartSession::class]);

// 7. FORMULARIO
Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');

// 8. Fallback global para rutas inexistentes → 404 personalizado
Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => '404 - Página no encontrada',
        'message' => 'La página que buscas no existe o fue eliminada.',
        'code' => 404,
        'exceptionMessage' => 'Ruta no encontrada'
    ], 404);
});
