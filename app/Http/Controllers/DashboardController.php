<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /* =========================================================
       1. VISTAS GENERALES (Home, Calculadora, Error)
    ========================================================= */

    public function index()
    {
        return view('dashboard.home');
    }

    public function calculadora()
    {
        return view('dashboard.calculadora');
    }

    public function errorDemo()
    {
        // Simulamos un error 500 controlado para probar la vista de errores
        return response()->view('dashboard.error-demo', [
            'title' => '¡Ups! Algo salió mal',
            'message' => 'Ha ocurrido un error inesperado en el sistema.',
            'code' => 500,
            'exceptionMessage' => 'Simulation_Exception: Este es un mensaje de prueba generado por el controlador.'
        ], 500);
    }

    /* =========================================================
       2. CLICKER (Contador simple con Base de Datos)
    ========================================================= */

    public function clicker()
    {
        try {
            // Intenta contar; si la tabla no existe, devuelve 0 en lugar de error
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

        return back()->with('success', '¡Click registrado exitosamente!');
    }

    /* =========================================================
       3. FORMULARIO DE CONTACTO (Vista + API Fetch)
    ========================================================= */

    public function formulario()
    {
        return view('dashboard.formulario');
    }

    public function validarFormulario(Request $request)
    {
        // 1. Validación estricta
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:50',
            'email'  => [
                'required',
                'string',
                'max:255',
                // Regex simple para asegurar formato email
                'regex:/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/'
            ],
            'fecha_nacimiento' => 'required|date|before:today',
            'sitio_web'        => 'nullable|url',
            'mensaje'          => 'required|string|max:255',
        ], [
            'email.regex' => 'El formato del correo no es válido.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.'
        ]);

        // 2. Insertar en BD
        $nuevoId = DB::table('contactos')->insertGetId([
            'nombre'           => $validated['nombre'],
            'email'            => $validated['email'],
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'sitio_web'        => $validated['sitio_web'] ?? null,
            'mensaje'          => $validated['mensaje'],
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // 3. Respuesta JSON para JavaScript (Fetch)
        return response()->json([
            'success' => true,
            'message' => '¡Contacto guardado correctamente!',
            'data'    => [
                'id'     => $nuevoId,
                'nombre' => $validated['nombre'],
                'email'  => $validated['email']
            ]
        ]);
    }

    /* =========================================================
       4. CARRUSEL DE IMÁGENES (Gestión de URLs)
    ========================================================= */

    public function carrusel()
    {
        // Obtenemos las imágenes ordenadas por la más reciente
        $imagenes = DB::table('carrusel_images')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.carrusel', compact('imagenes'));
    }

    public function subirFoto(Request $request)
    {
        $request->validate([
            'image_url' => 'required|url',
        ], [
            'image_url.required' => 'Debes proporcionar una URL.',
            'image_url.url'      => 'El formato debe ser una URL válida (http/https).'
        ]);

        DB::table('carrusel_images')->insert([
            'url'        => $request->image_url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', '¡Imagen agregada al carrusel!');
    }

    public function eliminarFoto($id)
    {
        $deleted = DB::table('carrusel_images')
            ->where('id', $id)
            ->delete();

        if ($deleted) {
            return back()->with('success', 'Imagen eliminada correctamente.');
        }

        return back()->with('error', 'No se pudo encontrar la imagen para eliminar.');
    }
}