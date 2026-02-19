<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use PragmaRX\Google2FA\Google2FA; // Librería del QR

class AuthController extends Controller
{
    // ================= LOGIN Y REGISTER =================

    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required' // El campo del captcha
        ]);

        if (!$this->checkRecaptcha($request->input('g-recaptcha-response'))) {
            return back()->withErrors(['captcha' => 'Por favor verifica que no eres un robot.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'google2fa_secret' => null // Empieza sin 2FA
        ]);

        Auth::login($user);
        
        // Al registrarse, lo mandamos directo a configurar su QR
        return redirect()->route('2fa.setup');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        if (!$this->checkRecaptcha($request->input('g-recaptcha-response'))) {
            return back()->withErrors(['captcha' => 'Fallo en la verificación de robot.']);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            // Login correcto con password.
            // El middleware se encargará de redirigir a /2fa/verify o /2fa/setup
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // ================= LÓGICA 2FA (QR) =================

    // 1. Mostrar QR para configurar (Solo primera vez)
    public function setup2fa() {
        $google2fa = new Google2FA();
        $user = Auth::user();

        // Generar clave secreta
        $secretKey = $google2fa->generateSecretKey();
        
        // Guardar temporalmente en sesión para validarla antes de guardar en BD
        session(['2fa_secret_temp' => $secretKey]);

        // Generar imagen QR
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretKey
        );

        return view('auth.2fa_setup', compact('QR_Image', 'secretKey'));
    }

    // 2. Guardar configuración 2FA
    public function enable2fa(Request $request) {
        $request->validate(['code' => 'required']);
        $google2fa = new Google2FA();
        $secret = session('2fa_secret_temp');

        // Verificar que el código que puso el usuario coincide con el QR generado
        $valid = $google2fa->verifyKey($secret, $request->code);

        if ($valid) {
            $user = Auth::user();
            $user->google2fa_secret = $secret;
            $user->save();
            
            // Marcar como verificado en sesión
            session(['2fa_verified' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código incorrecto. Intenta escanear de nuevo.']);
    }

    // 3. Pantalla de bloqueo (Login normal)
    public function show2faVerify() {
        return view('auth.2fa_verify');
    }

    // 4. Validar código al entrar
    public function verify2fa(Request $request) {
        $request->validate(['code' => 'required']);
        $user = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código inválido.']);
    }

    // ================= HELPER RECAPTCHA =================
    private function checkRecaptcha($token) {
        // CLAVE SECRETA DE PRUEBA DE GOOGLE (Cámbiala por la tuya en producción)
        // Esta clave es universal para pruebas en localhost
        $secret = '6LeIxAcTAAAAAGG-vFI1TnRWxPZ7d02FZSV8eb-o'; 
        
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token
        ]);

        return $response->json()['success'];
    }
}