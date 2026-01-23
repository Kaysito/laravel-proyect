<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// 1. IMPORTANTE: Importamos la librería de Cloudinary
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

    // 5. Muestra el carrusel (CONECTADO A CLOUDINARY)
    public function carrusel()
    {
        // Intentamos obtener las imágenes con la etiqueta 'carrusel'
        try {
            $search = Cloudinary::search()
                ->expression('tags=carrusel')
                ->withField('context')
                ->sortBy('created_at', 'desc') // Ordenamos por las más nuevas
                ->maxResults(10)
                ->execute();

            $imagenes = $search['resources'];
        } catch (\Exception $e) {
            // Si falla (o no hay internet/claves), enviamos una lista vacía
            $imagenes = [];
        }

        return view('dashboard.carrusel', ['imagenes' => $imagenes]);
    }

    // 6. Muestra la página de error demo
    public function errorDemo()
    {
        return view('dashboard.error-demo');
    }

    // === MÉTODOS PARA EL FORMULARIO ===

    // 7. Muestra la vista del formulario
    public function formulario()
    {
        return view('dashboard.formulario');
    }

    // 8. Procesa y valida los datos
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

        return back()->with('success', '¡Formulario enviado y validado perfectamente!');
    }

    // === NUEVO MÉTODO PARA SUBIR FOTOS (CORREGIDO) ===

    // 9. Sube una foto a Cloudinary
    public function subirFoto(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Subimos a Cloudinary y le ponemos la etiqueta 'carrusel'
            Cloudinary::upload($request->file('imagen')->getRealPath())
                ->withTag('carrusel'); // <--- CORREGIDO: Ya no tiene el ->upload() extra que daba error
            
            return back()->with('success', '¡Foto subida correctamente! Recarga si no la ves al instante.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al subir: ' . $e->getMessage());
        }
    }
}