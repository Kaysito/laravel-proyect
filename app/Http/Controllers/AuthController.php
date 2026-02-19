<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; 

class AuthController extends Controller
{
    // ==========================================
    // 1. LOGIN
    // ==========================================
    public function showLogin()
    {
        return view('auth.login', ['siteKey' => env('RECAPTCHA_SITE_KEY')]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]);

        if (! $this->validarCaptcha($request)) {
             return back()->withErrors(['captcha' => 'Debes completar el captcha correctamente.']);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if (is_null($user->google2fa_secret)) {
                return redirect()->route('2fa.setup');
            }
            return redirect()->route('2fa.index');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

    // ==========================================
    // 2. REGISTRO
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

        if (! $this->validarCaptcha($request)) {
            return back()->withErrors(['captcha' => 'Error en el captcha.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'google2fa_secret' => null
        ]);

        Auth::login($user);
        return redirect()->route('2fa.setup');
    }

    // ==========================================
    // 3. CAPTCHA
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
            return true; // Fail-open para evitar bloqueos por error de conexión
        }
    }

    // ==========================================
    // 4. LÓGICA 2FA (CORREGIDA)
    // ==========================================

    public function setup2fa()
    {
        // CORRECCIÓN: Usamos app() en lugar de new Google2FA()
        $google2fa = app('pragmarx.google2fa'); 
        $user = Auth::user();
        
        $secretKey = $google2fa->generateSecretKey();
        
        session(['2fa_secret_temp' => $secretKey]);

        // Ahora sí funcionará getQRCodeInline porque estamos usando la instancia correcta
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
        
        // CORRECCIÓN: Usamos app()
        $google2fa = app('pragmarx.google2fa');
        $secret = session('2fa_secret_temp');

        if ($google2fa->verifyKey($secret, $request->code)) {
            $user = Auth::user();
            $user->google2fa_secret = $secret;
            $user->save();
            
            session(['2fa_verified' => true]);
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
        // CORRECCIÓN: Usamos app()
        $google2fa = app('pragmarx.google2fa');

        if ($google2fa->verifyKey($user->google2fa_secret, $request->code)) {
            session(['2fa_verified' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['code' => 'Código inválido.']);
    }
}