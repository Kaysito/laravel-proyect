@extends('layout')

@section('content')
    @if($esExito)
        <div class="text-green-500 mb-4">
            <i class="fa-solid fa-circle-check text-6xl animate-bounce"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">¡Verificación Exitosa!</h1>
        <p class="text-slate-600">{{ $mensaje }}</p>
    @else
        <div class="text-red-500 mb-4">
            <i class="fa-solid fa-circle-xmark text-6xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-800 mb-2">Error</h1>
        <p class="text-slate-600">{{ $mensaje }}</p>
    @endif

    <a href="/" class="mt-6 inline-block w-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-4 rounded-lg transition duration-300">
        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al inicio
    </a>
@endsection