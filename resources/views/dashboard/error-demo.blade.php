@extends('layout')

@section('breadcrumb', $breadcrumb ?? 'Error')

@section('content')
    <div class="py-10 text-center">
        <div class="text-red-500 text-6xl mb-4 animate-bounce">
            <i class="fa-solid fa-bug"></i>
        </div>
        
        <h2 class="text-4xl font-bold text-slate-800 mb-2">{{ $title ?? '¡Ups! Algo salió mal' }}</h2>
        <p class="text-slate-500 mb-6 text-lg">{{ $message ?? 'Ha ocurrido un error inesperado en el sistema.' }}</p>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8 text-left text-sm font-mono text-red-700">
            <p><strong>Error Code:</strong> {{ $code ?? '500' }}</p>
            <p><strong>Message:</strong> {{ $exceptionMessage ?? 'Simulation_Exception: Este es un mensaje de prueba.' }}</p>
        </div>

        <div class="space-x-4">
            <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg">
                <i class="fa-solid fa-house mr-2"></i> Ir al Inicio
            </a>
            
            <button onclick="location.reload()" class="bg-white text-slate-600 border border-slate-300 px-6 py-3 rounded-lg font-bold hover:bg-slate-50 transition">
                <i class="fa-solid fa-rotate-right mr-2"></i> Reintentar
            </button>
        </div>
    </div>
@endsection
