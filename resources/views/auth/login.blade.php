@extends('layout')
@section('title', 'Iniciar Sesión')
@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login Seguro</h2>
    
    {{-- Formulario apuntando a la ruta POST correcta --}}
    <form action="{{ route('login.attempt') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-2">Contraseña</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        {{-- RECAPTCHA CORREGIDO: Usa la variable dinámica del controlador --}}
        <div class="mb-4 flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
        </div>
        
        @error('captcha') <p class="text-red-500 text-sm mb-4">{{ $message }}</p> @enderror
        @error('email') <p class="text-red-500 text-sm mb-4">{{ $message }}</p> @enderror

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Entrar</button>
    </form>
    <p class="mt-4 text-center">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-500">Regístrate</a></p>
</div>
@endsection