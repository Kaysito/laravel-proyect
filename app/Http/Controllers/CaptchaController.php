<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CaptchaController extends Controller
{
    public function showLogin()
    {
        return view('welcome', ['siteKey' => env('RECAPTCHA_SITE_KEY')]);
    }

    public function verifyLogin(Request $request)
    {
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        $token = $request->input('g-recaptcha-response');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        if ($response->json()['success']) {
            return redirect()->route('home');
        } else {
            return back()->with('error', 'Debes completar el captcha correctamente.');
        }
    }
}