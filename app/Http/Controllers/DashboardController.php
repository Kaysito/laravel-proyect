<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // 1. Muestra el menú principal (Home)
    public function index()
    {
        return view('dashboard.home');
    }

    // 2. Muestra la calculadora
    public function calculadora()
    {
        return view('dashboard.calculadora');
    }

    // 3. Muestra la sección del clicker
    public function clicker()
    {
        try {
            $totalClicks = DB::table('click_tests')->count();
        } catch (\Exception $e) {
            $totalClicks = 0;
        }
        
        return view('dashboard.clicker', ['total' => $totalClicks]);
    }

    // 4. Guarda el click en la BD
    public function storeClick()
    {
        DB::table('click_tests')->insert([
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', '¡Click guardado exitosamente!');
    }

    // 5. Muestra el carrusel
    public function carrusel()
    {
        return view('dashboard.carrusel');
    }

    // 6. Muestra la página de error demo
    public function errorDemo()
    {
        return view('dashboard.error-demo');
    }

    // === NUEVOS MÉTODOS PARA EL FORMULARIO ===

    // 7. Muestra la vista del formulario
    public function formulario()
    {
        return view('dashboard.formulario');
    }

    // 8. Procesa y valida los datos (Sin base de datos)
    public function validarFormulario(Request $request)
    {
        // VALIDACIÓN STRICTA (Back-end)
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:50',
            'email'  => 'required|email:rfc,dns',
            'edad'   => 'required|integer|min:18|max:100',
            'fecha_nacimiento' => 'required|date|before:today',
            'sitio_web' => 'nullable|url',
            'mensaje' => 'required|string|max:255',
        ]);

        return back()->with('success', '¡Formulario enviado y validado perfectamente! Datos limpios recibidos.');
    }
}