<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CaptchaController extends Controller
{
    // Muestra el formulario
    public function index()
    {
        // CAMBIO: Ahora leemos la variable de entorno
        $siteKey = env('RECAPTCHA_SITE_KEY');

        return view('welcome', [
            'siteKey' => $siteKey
        ]);
    }

    // Procesa el click
    public function store(Request $request)
    {
        // CAMBIO: Ahora leemos la variable de entorno
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        
        $token = $request->input('g-recaptcha-response');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        if ($response->json()['success']) {
            
            DB::table('click_tests')->insert([
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return view('mensaje', [
                'esExito' => true,
                'mensaje' => 'Tu click ha sido guardado correctamente en la base de datos.'
            ]);
        } else {
            return view('mensaje', [
                'esExito' => false,
                'mensaje' => 'No pudimos verificar que seas humano. Inténtalo de nuevo.'
            ]);
        }
    }
}