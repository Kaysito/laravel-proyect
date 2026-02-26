<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;

// 1. RUTAS DE INVITADO (Login y Registro)
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.attempt');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register');
});

// 2. RUTAS AUTENTICADAS (Requieren sesión iniciada)
Route::middleware('auth')->group(function () {
    
    // Cierre de sesión seguro
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Configuración y verificación 2FA
    Route::controller(AuthController::class)->prefix('2fa')->group(function () {
        Route::get('/setup', 'setup2fa')->name('2fa.setup');
        Route::post('/setup', 'enable2fa')->name('2fa.enable');
        
        Route::get('/verify', 'show2faVerify')->name('2fa.index');
        Route::post('/verify', 'verify2fa')->name('2fa.verify');
    });
});

// 3. RUTAS PROTEGIDAS (Autenticación + Verificación 2FA completada)
Route::middleware(['auth', '2fa'])->controller(DashboardController::class)->group(function () {
    
    // Dashboard Base
    Route::get('/home', 'index')->name('home');
    Route::redirect('/dashboard', '/home');

    // Herramientas y Utilidades
    Route::get('/calculadora', 'calculadora')->name('calculadora');
    
    Route::get('/clicker', 'clicker')->name('clicker');
    Route::post('/guardar-click', 'storeClick')->name('guardar.click');

    // Formulario
    Route::get('/formulario', 'formulario')->name('formulario');
    Route::post('/validar-formulario', 'validarFormulario')->name('formulario.validar');
    Route::get('/validar-formulario', function() { return redirect()->route('formulario'); });

    // Carrusel de Fotos
    Route::prefix('carrusel')->group(function () {
        Route::get('/', 'carrusel')->name('carrusel');
        Route::post('/subir', 'subirFoto')->name('carrusel.subir');
        Route::delete('/eliminar/{id}', 'eliminarFoto')->name('carrusel.eliminar');
    });

    // API Interna y Vista de Empleados/Contactos
    Route::get('/empleados', 'indexEmpleados')->name('empleados');
    
    Route::prefix('api')->group(function () {
        Route::get('/empleados', 'listarEmpleados');
        Route::post('/empleados', 'crearEmpleado');
        Route::put('/empleados/{id}', 'actualizarEmpleado');
        Route::delete('/empleados/{id}', 'eliminarEmpleado');

        Route::get('/contactos/buscar', 'buscarContactos')->name('contactos.buscar');
        Route::delete('/contactos/{id}', 'eliminarContacto')->name('contactos.eliminar');
    });
});

// 4. RUTAS DE ERRORES (Públicas)
Route::get('/error-demo', [DashboardController::class, 'errorDemo'])
    ->name('error.demo')
    ->withoutMiddleware([StartSession::class]);

Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => '404 - Página no encontrada',
        'message' => 'La página que buscas no existe o fue eliminada.',
        'code' => 404,
        'exceptionMessage' => 'Ruta no encontrada'
    ], 404);
});