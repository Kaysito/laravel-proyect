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
        // Si la tabla no existe aún, esto podría dar error, pero asumimos que ya migraste
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

    // === AQUÍ ESTABAN LOS MÉTODOS QUE FALTABAN ===

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
}