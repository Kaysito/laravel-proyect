<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DashboardController extends Controller
{
    // ... (Tus funciones index, calculadora, clicker, storeClick siguen igual) ...
    public function index() { return view('dashboard.home'); }
    public function calculadora() { return view('dashboard.calculadora'); }
    
    public function clicker() {
        try { $totalClicks = DB::table('click_tests')->count(); } catch (\Exception $e) { $totalClicks = 0; }
        return view('dashboard.clicker', ['total' => $totalClicks]);
    }

    public function storeClick() {
        DB::table('click_tests')->insert(['created_at' => now(), 'updated_at' => now()]);
        return back()->with('success', '¡Click guardado exitosamente!');
    }

    public function errorDemo() { return view('dashboard.error-demo'); }
    public function formulario() { return view('dashboard.formulario'); }
    
    public function validarFormulario(Request $request) {
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

    // === AQUÍ ESTÁ EL CAMBIO IMPORTANTE (USANDO CARPETAS) ===

    // 5. Muestra el carrusel (BUSCA EN LA CARPETA 'carrusel')
    public function carrusel()
    {
        $imagenes = [];
        try {
            // Buscamos explícitamente en la carpeta 'carrusel'
            $search = Cloudinary::search()
                ->expression('folder:carrusel') // <--- CAMBIO AQUÍ
                ->sortBy('created_at', 'desc')
                ->maxResults(10)
                ->execute();

            if (isset($search['resources'])) {
                $imagenes = $search['resources'];
            }
        } catch (\Exception $e) {
            // Si falla, $imagenes se queda vacío
        }
        return view('dashboard.carrusel', ['imagenes' => $imagenes]);
    }

    // 9. Sube una foto a Cloudinary (A LA CARPETA 'carrusel')
    public function subirFoto(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
        ]);

        try {
            // Subimos la foto DIRECTO a una carpeta llamada "carrusel"
            Cloudinary::upload($request->file('imagen')->getRealPath(), [
                'folder' => 'carrusel', // <--- ESTO CREA LA CARPETA VISIBLE
                'public_id' => 'foto_' . time() // Le damos un nombre único
            ]);
            
            return back()->with('success', '¡Foto guardada en la carpeta "carrusel" de Cloudinary!');

        } catch (\Exception $e) {
            // ESTO TE DIRÁ POR QUÉ FALLA EN UN MENSAJE ROJO
            return back()->with('error', 'Error crítico: ' . $e->getMessage());
        }
    }
}