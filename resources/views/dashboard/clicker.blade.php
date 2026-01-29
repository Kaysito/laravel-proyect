@extends('layout')

@section('breadcrumb', 'Zona de Pruebas')

@section('content')
<div class="max-w-md mx-auto text-center">

    {{-- Encabezado --}}
    <div class="mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4 shadow-sm">
            <i class="fa-solid fa-database text-3xl"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-800">Clicker Database</h2>
        <p class="text-slate-500 mt-2">Prueba de conexión y escritura en Base de Datos.</p>
    </div>

    {{-- Contador Grande --}}
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200 mb-8 transition hover:shadow-md">
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Total de Clicks</p>
        
        {{-- AQUÍ ESTABA EL ERROR: Cambiamos $total por $totalClicks --}}
        <div class="text-6xl font-black text-indigo-600 font-mono tracking-tighter">
            {{ $totalClicks }}
        </div>
    </div>

    {{-- Mensajes de Éxito --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-center gap-2 animate-bounce">
            <i class="fa-solid fa-check-circle"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Botón de Acción --}}
    <form action="{{ route('guardar.click') }}" method="POST">
        @csrf
        <button type="submit" class="group w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all transform active:scale-95 flex items-center justify-center gap-3">
            <span class="text-lg">¡Registrar Click!</span>
            <i class="fa-solid fa-hand-pointer text-xl group-hover:rotate-12 transition-transform"></i>
        </button>
    </form>

    <div class="mt-8">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 transition text-sm font-medium flex items-center justify-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver al inicio
        </a>
    </div>

</div>
@endsection