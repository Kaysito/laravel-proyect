@extends('layout')

@section('content')
    <div class="mb-6">
        <i class="fa-solid fa-shield-cat text-5xl text-indigo-500 mb-4"></i>
        <h1 class="text-2xl font-bold text-slate-800">Acceso Seguro</h1>
        <p class="text-slate-500 mt-2 text-sm">Resuelve el captcha para entrar al sistema.</p>
    </div>
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-sm">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <form action="/verificar-acceso" method="POST" class="space-y-6">
        @csrf 
        
        <div class="flex justify-center">
            <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
        </div>

        <button type="submit" 
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-md flex items-center justify-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i> Ingresar al Dashboard
        </button>
    </form>
@endsection