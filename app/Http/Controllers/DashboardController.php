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
    // ERROR DEMO
    // ===============================
    public function errorDemo()
    {
        return response()->view('dashboard.error-demo', [
            'title' => '¡Ups! Algo salió mal',
            'message' => 'Ha ocurrido un error inesperado en el sistema.',
            'code' => 500,
            'exceptionMessage' => 'Simulation_Exception: Este es un mensaje de prueba.'
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
       FORMULARIO (FETCH + DB CONTACTOS)
    =============================== */

    public function validarFormulario(Request $request)
    {
        // 1. Validación de datos
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:50',
            'email' => [
                'required',
                'string',
                'max:255',
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/'
            ],
            'fecha_nacimiento' => 'required|date|before:today',
            'sitio_web' => 'nullable|url',
            'mensaje' => 'required|string|max:255',
        ], [
            'email.regex' => 'El correo debe ser válido y puede usar cualquier dominio.'
        ]);

        // 2. Insertar en la Base de Datos (Tabla 'contactos')
        // Usamos insertGetId para obtener el ID y mostrarlo en el DOM si quieres
        $nuevoId = DB::table('contactos')->insertGetId([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sitio_web' => $validated['sitio_web'] ?? null, // Manejo de nulos
            'mensaje' => $validated['mensaje'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Retornar JSON para el Fetch
        // Devolvemos los datos procesados para que JS manipule el DOM
        return response()->json([
            'success' => true,
            'message' => '¡Contacto guardado correctamente!',
            'data' => [
                'id' => $nuevoId,
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'fecha' => $validated['fecha_nacimiento'],
                'mensaje' => $validated['mensaje']
            ]
        ]);
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