<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Session\Middleware\StartSession;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/2fa/setup', [AuthController::class, 'setup2fa'])->name('2fa.setup');
    Route::post('/2fa/setup', [AuthController::class, 'enable2fa'])->name('2fa.enable');

    Route::get('/2fa/verify', [AuthController::class, 'show2faVerify'])->name('2fa.index');
    Route::post('/2fa/verify', [AuthController::class, 'verify2fa'])->name('2fa.verify');
});

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::redirect('/dashboard', '/home');

    Route::get('/calculadora', [DashboardController::class, 'calculadora'])->name('calculadora');

    Route::get('/clicker', [DashboardController::class, 'clicker'])->name('clicker');
    Route::post('/guardar-click', [DashboardController::class, 'storeClick'])->name('guardar.click');

    Route::get('/carrusel', [DashboardController::class, 'carrusel'])->name('carrusel');
    Route::post('/carrusel/subir', [DashboardController::class, 'subirFoto'])->name('carrusel.subir');
    Route::delete('/carrusel/eliminar/{id}', [DashboardController::class, 'eliminarFoto'])->name('carrusel.eliminar');

    Route::get('/formulario', [DashboardController::class, 'formulario'])->name('formulario');
    Route::post('/validar-formulario', [DashboardController::class, 'validarFormulario'])->name('formulario.validar');
    Route::get('/validar-formulario', function() { return redirect()->route('formulario'); });

    Route::get('/empleados', [DashboardController::class, 'indexEmpleados'])->name('empleados');
    Route::get('/api/empleados', [DashboardController::class, 'listarEmpleados']);
    Route::post('/api/empleados', [DashboardController::class, 'crearEmpleado']);
    Route::put('/api/empleados/{id}', [DashboardController::class, 'actualizarEmpleado']);
    Route::delete('/api/empleados/{id}', [DashboardController::class, 'eliminarEmpleado']);

    Route::get('/api/contactos/buscar', [DashboardController::class, 'buscarContactos'])->name('contactos.buscar');
    Route::delete('/api/contactos/{id}', [DashboardController::class, 'eliminarContacto'])->name('contactos.eliminar');
});

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