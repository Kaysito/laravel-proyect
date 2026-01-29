<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /* ===============================
       VISTAS BÁSICAS
    =============================== */

    public function index()
    {
        return view('dashboard.home');
    }

    public function calculadora()
    {
        return view('dashboard.calculadora');
    }

    // ===============================
    // ERROR DEMO → Muestra un error 500 simulado
    // ===============================
    public function errorDemo()
    {
        // Devuelve la vista de error-demo con status 500
        return response()->view('dashboard.error-demo', [
            'breadcrumb' => 'Simulación de Error'
        ], 500);
    }

    public function formulario()
    {
        return view('dashboard.formulario');
    }

    /* ===============================
       CLICKER
    =============================== */

    public function clicker()
    {
        try {
            $totalClicks = DB::table('click_tests')->count();
        } catch (\Throwable $e) {
            $totalClicks = 0;
        }

        return view('dashboard.clicker', compact('totalClicks'));
    }

    public function storeClick()
    {
        DB::table('click_tests')->insert([
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '¡Click guardado exitosamente!');
    }

    /* ===============================
       FORMULARIO
    =============================== */

    public function validarFormulario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:3|max:50',
            'email'  => 'required|email:rfc,dns',
            'edad'   => 'required|integer|min:18|max:100',
            'fecha_nacimiento' => 'required|date|before:today',
            'sitio_web' => 'nullable|url',
            'mensaje' => 'required|string|max:255',
        ]);

        return back()->with('success', '¡Formulario enviado correctamente!');
    }

    /* ===============================
       CARRUSEL (UPLOADCARE + DB)
    =============================== */

    public function carrusel()
    {
        $imagenes = DB::table('carrusel_images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.carrusel', compact('imagenes'));
    }

    public function subirFoto(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ]);

        DB::table('carrusel_images')->insert([
            'url' => $request->image_url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '¡Imagen agregada al carrusel!');
    }

    public function eliminarFoto($id)
    {
        DB::table('carrusel_images')
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Imagen eliminada correctamente');
    }
}
