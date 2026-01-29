@extends('layout')

@section('breadcrumb', 'Error 404')

@section('content')
<div class="flex flex-col items-center justify-center min-h-[70vh] px-4 text-center">

    {{-- Icono de advertencia --}}
    <div class="text-amber-500 mb-6 animate-pulse">
        <i class="fa-solid fa-triangle-exclamation text-8xl"></i>
    </div>

    {{-- Código de error --}}
    <h1 class="text-7xl font-black text-slate-800 mb-2">404</h1>

    {{-- Mensaje --}}
    <h2 class="text-3xl font-bold text-slate-700 mb-4">Página no encontrada</h2>
    <p class="text-slate-500 mb-6 max-w-md">
        Lo sentimos, la página que buscas no existe o fue eliminada. Verifica la URL o regresa al inicio.
    </p>

    {{-- Botón de regreso --}}
    <a href="{{ route('home') }}" 
       class="inline-block w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-lg flex items-center justify-center gap-2">
        <i class="fa-solid fa-house"></i> Regresar a Inicio
    </a>
</div>
@endsection
