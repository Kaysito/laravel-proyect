@extends('layout')
@section('title', 'Configurar 2FA')
@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded shadow text-center">
    <h2 class="text-2xl font-bold mb-4">Configura tu Doble Factor</h2>
    <p class="mb-6 text-gray-600">Escanea este código con Google Authenticator en tu celular.</p>

    <div class="flex justify-center mb-6">
        {!! $QR_Image !!}
    </div>
    
    <p class="text-sm text-gray-500 mb-6">O ingresa esta clave manualmente: <strong>{{ $secretKey }}</strong></p>

    <form action="{{ route('2fa.enable') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-2 font-bold">Ingresa el código que aparece en tu app:</label>
            <input type="text" name="code" class="w-full border p-2 rounded text-center text-xl tracking-widest" placeholder="123456" required>
        </div>
        @error('code') <p class="text-red-500 text-sm mb-4">{{ $message }}</p> @enderror

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Activar y Continuar</button>
    </form>
</div>
@endsection