<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController; // <--- Controlador Nuevo
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==============================================================================
//  GRUPO 1: INVITADOS (GUEST)
//  Solo pueden ver esto si NO han iniciado sesión.
// ==============================================================================
Route::middleware('guest')->group(function () {
    // Login con ReCaptcha
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Registro con ReCaptcha
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==============================================================================
//  GRUPO 2: AUTENTICADOS (AUTH) - PERO SIN 2FA OBLIGATORIO AÚN
//  Aquí van Logout y la configuración del 2FA (si no, sería un bucle infinito).
// ==============================================================================
Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // --- RUTAS DE 2FA ---
    // Configuración inicial (Para nuevos usuarios)
    Route::get('/2fa/setup', [AuthController::class, 'setup2fa'])->name('2fa.setup');
    Route::post('/2fa/setup', [AuthController::class, 'enable2fa'])->name('2fa.enable');

    // Pantalla de bloqueo (Donde pones el código al entrar)
    Route::get('/2fa/verify', [AuthController::class, 'show2faVerify'])->name('2fa.index');
    Route::post('/2fa/verify', [AuthController::class, 'verify2fa'])->name('2fa.verify');
});

// ==============================================================================
//  GRUPO 3: ZONA SEGURA (AUTH + 2FA)
//  Aquí va TODO lo importante. Si no pasas el QR, no entras aquí.
// ==============================================================================
Route::middleware(['auth', '2fa'])->group(function () {

    // 1. DASHBOARD
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::redirect('/dashboard', '/home'); 

    // 2. CALCULADORA
    Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

    // 3. CLICKER
    Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
    Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

    // 4. CARRUSEL
    Route::get('/carrusel', [DashboardController::class, 'carrusel'])->name('carrusel');
    Route::post('/carrusel/subir', [DashboardController::class, 'subirFoto'])->name('carrusel.subir');
    Route::delete('/carrusel/eliminar/{id}', [DashboardController::class, 'eliminarFoto'])->name('carrusel.eliminar');

    // 5. FORMULARIO DE CONTACTO
    Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
    Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');
    // Redirección para evitar error GET en ruta POST
    Route::get('/validar-formulario', function() { return redirect()->route('formulario'); });

    // 6. EMPLEADOS (Vista y API)
    Route::get('/empleados', [DashboardController::class, 'indexEmpleados'])->name('empleados');
    
    // APIs protegidas (Solo accesibles si ya pasaste el 2FA)
    Route::get('/api/empleados', [DashboardController::class, 'listarEmpleados']);
    Route::post('/api/empleados', [DashboardController::class, 'crearEmpleado']);
    Route::put('/api/empleados/{id}', [DashboardController::class, 'actualizarEmpleado']);
    Route::delete('/api/empleados/{id}', [DashboardController::class, 'eliminarEmpleado']);

    // APIs Contactos
    Route::get('/api/contactos/buscar', [DashboardController::class, 'buscarContactos'])->name('contactos.buscar');
    Route::delete('/api/contactos/{id}', [DashboardController::class, 'eliminarContacto'])->name('contactos.eliminar');
});

// ==============================================================================
//  RUTAS SIN PROTECCIÓN ESPECIAL (Errores, Demos)
// ==============================================================================

// Error Demo (Lo dejamos fuera del 2FA para probar errores libremente)
Route::get('/error-demo', [DashboardController::class, 'errorDemo'])
    ->name('error.demo')
    ->withoutMiddleware([StartSession::class]);

// Fallback global (404)
Route::fallback(function () {
    return response()->view('errors.404', [
        'title' => '404 - Página no encontrada',
        'message' => 'La página que buscas no existe o fue eliminada.',
        'code' => 404,
        'exceptionMessage' => 'Ruta no encontrada'
    ], 404);
});