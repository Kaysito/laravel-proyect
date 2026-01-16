@extends('layout')

@section('content')
    <div class="mb-6">
        <i class="fa-solid fa-robot text-5xl text-indigo-500 mb-4"></i>
        <h1 class="text-2xl font-bold text-slate-800">Verificación de Seguridad</h1>
        <p class="text-slate-500 mt-2 text-sm">Por favor, completa el captcha.</p>
    </div>
    
    <form action="/guardar-click" method="POST" class="space-y-6">
        @csrf <div class="flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
        </div>

        <button type="submit" 
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-md flex items-center justify-center gap-2">
            <i class="fa-solid fa-check-circle"></i> Guardar Click Seguro
        </button>
    </form>
@endsection