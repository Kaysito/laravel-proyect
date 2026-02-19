@extends('layout') {{-- Asegúrate de que extienda de 'layout' --}}

@section('title', 'Crear Cuenta')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow mt-10 text-left">
    <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">Crear Cuenta Nueva</h2>
    
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        {{-- Nombre --}}
        <div class="mb-4">
            <label class="block mb-2 font-bold text-slate-600 text-sm">Nombre</label>
            <input type="text" name="name" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-indigo-500" required>
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label class="block mb-2 font-bold text-slate-600 text-sm">Email</label>
            <input type="email" name="email" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-indigo-500" required>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label class="block mb-2 font-bold text-slate-600 text-sm">Contraseña</label>
            <input type="password" name="password" class="w-full border border-slate-300 p-2 rounded focus:outline-none focus:border-indigo-500" required>
        </div>

        {{-- RECAPTCHA CORREGIDO (Dinámico) --}}
        <div class="mb-4 flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
        </div>
        
        {{-- Errores --}}
        @error('captcha') <p class="text-red-500 text-sm mb-4 text-center">{{ $message }}</p> @enderror
        @error('email') <p class="text-red-500 text-sm mb-4 text-center">{{ $message }}</p> @enderror
        @error('password') <p class="text-red-500 text-sm mb-4 text-center">{{ $message }}</p> @enderror

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded transition">
            Registrarse
        </button>
    </form>
    
    <p class="mt-4 text-center text-sm text-slate-500">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Inicia Sesión</a>
    </p>
</div>
@endsection