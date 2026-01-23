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

    // 5. Muestra el carrusel (BLINDADO CONTRA ERRORES)
    public function carrusel()
    {
        $imagenes = []; // Iniciamos vacío por seguridad

        try {
            // Buscamos las imágenes con la etiqueta 'carrusel'
            $search = Cloudinary::search()
                ->expression('tags=carrusel')
                ->withField('context')
                ->sortBy('created_at', 'desc')
                ->maxResults(10)
                ->execute();

            // CORRECCIÓN IMPORTANTE:
            // Verificamos si Cloudinary nos devolvió algo válido antes de usarlo.
            // Esto evita el error "Trying to access array offset on value of type null"
            if (isset($search['resources'])) {
                $imagenes = $search['resources'];
            }

        } catch (\Exception $e) {
            // Si falla la conexión, no hacemos nada y dejamos $imagenes vacío
            // Así la página carga igual, solo que sin fotos.
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
            // Subimos a Cloudinary y le pegamos la etiqueta 'carrusel'
            Cloudinary::upload($request->file('imagen')->getRealPath())
                ->withTag('carrusel'); 
            
            return back()->with('success', '¡Foto subida correctamente! Recarga si no la ves al instante.');

        } catch (\Exception $e) {
            // Si falla, mostramos el error exacto en pantalla roja
            return back()->with('error', 'Error al subir: ' . $e->getMessage());
        }
    }
}