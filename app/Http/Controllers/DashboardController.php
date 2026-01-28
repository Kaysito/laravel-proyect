<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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

    public function errorDemo()
    {
        return view('dashboard.error-demo');
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
        } catch (\Exception $e) {
            $totalClicks = 0;
        }

        return view('dashboard.clicker', [
            'total' => $totalClicks
        ]);
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

        return back()->with('success', '¡Formulario enviado y validado correctamente!');
    }

    /* ===============================
       CARRUSEL (LISTAR IMÁGENES)
    =============================== */

    public function carrusel()
    {
        $imagenes = [];

        try {
            $search = Cloudinary::search()
                ->expression('folder:carrusel')
                ->sortBy('created_at', 'desc')
                ->maxResults(20)
                ->execute();

            // Compatible con array u objeto (Render / local)
            if (
                is_array($search) &&
                isset($search['resources']) &&
                is_array($search['resources'])
            ) {
                $imagenes = $search['resources'];
            } elseif (
                is_object($search) &&
                method_exists($search, 'getArrayCopy')
            ) {
                $data = $search->getArrayCopy();
                $imagenes = $data['resources'] ?? [];
            }

        } catch (\Exception $e) {
            logger()->error('Cloudinary search error: ' . $e->getMessage());
        }

        return view('dashboard.carrusel', compact('imagenes'));
    }

    /* ===============================
       SUBIR FOTO A CLOUDINARY
    =============================== */

    public function subirFoto(Request $request)
{
    $request->validate([
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5048',
    ]);

    try {
        $result = Cloudinary::upload(
            $request->file('imagen')->getRealPath(),
            [
                'folder' => 'carrusel',
                'public_id' => 'foto_' . uniqid(),
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ]
        );

        if (!$result || !method_exists($result, 'getSecurePath')) {
            throw new \Exception('Respuesta inválida de Cloudinary');
        }

        return back()->with(
            'success',
            '¡Imagen subida correctamente a Cloudinary!'
        );

    } catch (\Exception $e) {
        logger()->error('Cloudinary upload error: ' . $e->getMessage());

        return back()->with(
            'error',
            'Error al subir imagen: ' . $e->getMessage()
        );
    }
}

}
