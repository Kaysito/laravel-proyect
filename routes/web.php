<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. LOGIN
Route::get('/', [CaptchaController::class, 'showLogin'])->name('login');
Route::post('/verificar-acceso', [CaptchaController::class, 'verifyLogin']);

// LOGOUT
Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// 2. DASHBOARD
Route::get('/home', [DashboardController::class, 'index'])->name('home');
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


// 7. FORMULARIO DE CONTACTO
Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');

// Redirección para evitar error GET en ruta POST
Route::get('/validar-formulario', function() {
    return redirect()->route('formulario');
});

// Rutas API para Contactos (Si las tienes en el controlador)
Route::get('/api/contactos/buscar', [DashboardController::class, 'buscarContactos'])->name('contactos.buscar');
Route::delete('/api/contactos/{id}', [DashboardController::class, 'eliminarContacto'])->name('contactos.eliminar');


// ====================== 8. EMPLEADOS (CORREGIDO) ======================

// VISTA: Ahora apunta al controlador, no es una función suelta
Route::get('/empleados', [DashboardController::class, 'indexEmpleados'])->name('empleados');

// API - Listar
Route::get('/api/empleados', [DashboardController::class, 'listarEmpleados']);
// API - Crear
Route::post('/api/empleados', [DashboardController::class, 'crearEmpleado']);
// API - Eliminar
Route::delete('/api/empleados/{id}', [DashboardController::class, 'eliminarEmpleado']);

// ===> AGREGA ESTA LÍNEA PARA EDITAR <===
Route::put('/api/empleados/{id}', [DashboardController::class, 'actualizarEmpleado']);


// ======================================================================
// FALLBACK (SIEMPRE AL FINAL)
// ======================================================================
Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => '404 - Página no encontrada',
        'message' => 'La página que buscas no existe o fue eliminada.',
        'code' => 404,
        'exceptionMessage' => 'Ruta no encontrada'
    ], 404);
});

