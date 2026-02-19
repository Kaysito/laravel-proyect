@extends('layouts.app')
@section('title', 'Verificación de Seguridad')
@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow text-center">
    <h2 class="text-2xl font-bold mb-4 text-indigo-700">Autenticación en 2 Pasos</h2>
    <p class="mb-6 text-gray-600">Por favor ingresa el código de tu aplicación Google Authenticator.</p>

    <form action="{{ route('2fa.verify') }}" method="POST">
        @csrf
        <div class="mb-4">
            <input type="text" name="code" class="w-full border-2 border-indigo-200 p-3 rounded text-center text-2xl tracking-[0.5em] font-mono focus:border-indigo-500 focus:outline-none" placeholder="000000" autofocus required>
        </div>
        
        @error('code') 
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">{{ $message }}</div> 
        @enderror

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded transition">
            Verificar Acceso
        </button>
    </form>
</div>
@endsection