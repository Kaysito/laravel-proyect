<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // Necesario para tu lógica de Captcha
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    // ==========================================
    // 1. LOGIN (Con tu lógica de Captcha + Password)
    // ==========================================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validar inputs básicos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        // 2. TU LÓGICA DE CAPTCHA (Integrada aquí)
        // ------------------------------------------------------
        // Nota: Como dijiste que es testing, si no tienes claves en el .env
        // esto podría fallar. Si quieres saltarlo siempre, descomenta el "return true" abajo.
        
        if (! $this->validarCaptcha($request)) {
             return back()->withErrors(['captcha' => 'Debes completar el captcha correctamente.']);
        }
        // ------------------------------------------------------

        // 3. Validar Credenciales (Email y Password)
        if (Auth::attempt($request->only('email', 'password'))) {
            
            // ¡LOGIN EXITOSO! Ahora verificamos si tiene 2FA
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
    // 2. REGISTRO (También con Captcha)
    // ==========================================

    public function showRegister()
    {
        return view('auth.register');
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
    // 3. LÓGICA DE CAPTCHA (Tu código extraído)
    // ==========================================

    private function validarCaptcha($request)
    {
        // TRUCO PARA TESTING RÁPIDO:
        // Si quieres que pase SIEMPRE (aunque falle Google), descomenta la siguiente línea:
        // return true; 

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
            // Si hay error de conexión o algo raro, dejamos pasar en testing
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
        $secretKey = $google2fa->generateSecretKey();
        
        session(['2fa_secret_temp' => $secretKey]);

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

        if ($google2fa->verifyKey($secret, $request->code)) {
            $user = Auth::user();
            $user->google2fa_secret = $secret;
            $user->save();
            
            session(['2fa_verified' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código incorrecto.']);
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

        if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código inválido.']);
    }
}