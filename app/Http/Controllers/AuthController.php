<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Necesario para la petición a Google
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    // ==========================================
    // 1. LOGIN (Con Captcha dinámico + Password)
    // ==========================================

    public function showLogin()
    {
        // Pasamos la Site Key a la vista para que el widget se renderice bien
        return view('auth.login', ['siteKey' => env('RECAPTCHA_SITE_KEY')]);
    }

    public function login(Request $request)
    {
        // 1. Validar inputs básicos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        // 2. LÓGICA DE CAPTCHA
        if (! $this->validarCaptcha($request)) {
             return back()->withErrors(['captcha' => 'Debes completar el captcha correctamente.']);
        }

        // 3. Validar Credenciales (Email y Password)
        if (Auth::attempt($request->only('email', 'password'))) {
            
            // Login exitoso, ahora verificamos el estado del 2FA
            $user = Auth::user();

            // A. Si no tiene 2FA configurado -> Mandar a configurar
            if (is_null($user->google2fa_secret)) {
                return redirect()->route('2fa.setup');
            }

            // B. Si ya tiene 2FA -> Mandar a verificar código QR
            return redirect()->route('2fa.index');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // ==========================================
    // 2. REGISTRO (Con Captcha dinámico)
    // ==========================================

    public function showRegister()
    {
        return view('auth.register', ['siteKey' => env('RECAPTCHA_SITE_KEY')]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'g-recaptcha-response' => 'required'
        ]);

        // Validar Captcha antes de crear usuario
        if (! $this->validarCaptcha($request)) {
            return back()->withErrors(['captcha' => 'Error en el captcha.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'google2fa_secret' => null // Nulo al inicio
        ]);

        Auth::login($user);
        
        // Al registrarse, directo a configurar 2FA
        return redirect()->route('2fa.setup');
    }

    // ==========================================
    // 3. LÓGICA DE CAPTCHA (Usando .env)
    // ==========================================

    private function validarCaptcha($request)
    {
        try {
            $secretKey = env('RECAPTCHA_SECRET_KEY');
            $token = $request->input('g-recaptcha-response');
    
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);
    
            return $response->json()['success'];

        } catch (\Exception $e) {
            // En caso de error de conexión con Google, permitimos el paso (Fail-Open)
            // para no bloquear a los usuarios en producción si Google se cae.
            return true; 
        }
    }

    // ==========================================
    // 4. LÓGICA 2FA (Google Authenticator)
    // ==========================================

    public function setup2fa()
    {
        $google2fa = new Google2FA();
        $user = Auth::user();
        
        // Generar clave secreta
        $secretKey = $google2fa->generateSecretKey();
        
        // Guardar temporalmente en sesión
        session(['2fa_secret_temp' => $secretKey]);

        // Generar QR visual
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretKey
        );

        return view('auth.2fa_setup', compact('QR_Image', 'secretKey'));
    }

    public function enable2fa(Request $request)
    {
        $request->validate(['code' => 'required']);
        
        $google2fa = new Google2FA();
        $secret = session('2fa_secret_temp');

        // Verificar el código ingresado contra el secreto temporal
        if ($google2fa->verifyKey($secret, $request->code)) {
            $user = Auth::user();
            $user->google2fa_secret = $secret; // Guardar secreto definitivo en BD
            $user->save();
            
            session(['2fa_verified' => true]); // Marcar sesión como verificada
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código incorrecto. Intenta de nuevo.']);
    }

    public function show2faVerify()
    {
        return view('auth.2fa_verify');
    }

    public function verify2fa(Request $request)
    {
        $request->validate(['code' => 'required']);
        
        $user = Auth::user();
        $google2fa = new Google2FA();

        // Verificar código contra el secreto guardado en BD
        if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]); // Éxito
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código inválido.']);
    }
}