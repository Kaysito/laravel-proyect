<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request; // Necesario para el logout manual

// 1. LOGIN
Route::get('/', [CaptchaController::class, 'showLogin'])->name('login');
Route::post('/verificar-acceso', [CaptchaController::class, 'verifyLogin']);

// ==============================================================================
//  AGREGADO: LOGOUT (Es vital para salir del sistema)
// ==============================================================================
Route::post('/logout', function (Request $request) {
    // Lógica estándar de logout de Laravel
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// 2. DASHBOARD
Route::get('/home', [DashboardController::class, 'index'])->name('home');

// ==============================================================================
//  AGREGADO: REDIRECCIÓN AMIGABLE
//  Si alguien escribe "/dashboard", lo mandamos a "/home"
// ==============================================================================
Route::redirect('/dashboard', '/home'); 


// 3. CALCULADORA
Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

// 4. CLICKER
Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

// 5. CARRUSEL
Route::get('/carrusel', [DashboardController::class, 'carrusel'])->name('carrusel');
Route::post('/carrusel/subir', [DashboardController::class, 'subirFoto'])->name('carrusel.subir');
Route::delete('/carrusel/eliminar/{id}', [DashboardController::class, 'eliminarFoto'])->name('carrusel.eliminar');

// 6. ERROR DEMO
Route::get('/error-demo', [DashboardController::class, 'errorDemo'])
    ->name('error.demo')
    ->withoutMiddleware([StartSession::class]);

// 7. FORMULARIO
Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');

// ==============================================================================
//  AGREGADO: LA CURITA MÁGICA (Para evitar el Error 404/Fallback)
//  Si el navegador intenta entrar a validar-formulario por GET, lo devolvemos al form.
// ==============================================================================
Route::get('/validar-formulario', function() {
    return redirect()->route('formulario');
});


// 8. Fallback global
Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => '404 - Página no encontrada',
        'message' => 'La página que buscas no existe o fue eliminada.',
        'code' => 404,
        'exceptionMessage' => 'Ruta no encontrada'
    ], 404);
});