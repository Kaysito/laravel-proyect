<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Muestra el menú principal
    public function index()
    {
        return view('dashboard.home');
    }

    // Muestra la calculadora
    public function calculadora()
    {
        return view('dashboard.calculadora');
    }

    // Muestra la sección del click
    public function clicker()
    {
        // Contamos cuántos clicks llevamos en total para mostrarlo
        $totalClicks = DB::table('click_tests')->count();
        return view('dashboard.clicker', ['total' => $totalClicks]);
    }

    // Guarda el click en la BD
    public function storeClick()
    {
        DB::table('click_tests')->insert([
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', '¡Click guardado exitosamente!');
    }
}