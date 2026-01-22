@extends('layout')

@section('content')
    <h1 class="text-3xl font-bold text-slate-800 mb-2">Bienvenido al Sistema</h1>
    <p class="text-slate-500 mb-8">Selecciona una herramienta:</p>

    <div class="grid grid-cols-2 gap-4">
        
        <a href="{{ route('clicker') }}" class="group block p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-indigo-500 transition-all cursor-pointer">
            <div class="text-indigo-500 text-3xl mb-2 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <h3 class="font-bold text-slate-700">Clicker</h3>
            <p class="text-xs text-slate-500 mt-1">Registrar datos</p>
        </a>

        <a href="{{ route('calculadora') }}" class="group block p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-emerald-500 transition-all cursor-pointer">
            <div class="text-emerald-500 text-3xl mb-2 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <h3 class="font-bold text-slate-700">Calculadora</h3>
            <p class="text-xs text-slate-500 mt-1">Operaciones básicas</p>
        </a>

        <a href="{{ route('carrusel') }}" class="group block p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-amber-500 transition-all cursor-pointer">
            <div class="text-amber-500 text-3xl mb-2 group-hover:scale-110 transition-transform">
                <i class="fa-regular fa-images"></i>
            </div>
            <h3 class="font-bold text-slate-700">Galería</h3>
            <p class="text-xs text-slate-500 mt-1">Carrusel de fotos</p>
        </a>

        <a href="{{ route('error.demo') }}" class="group block p-6 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-red-500 transition-all cursor-pointer">
            <div class="text-red-500 text-3xl mb-2 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-bug"></i>
            </div>
            <h3 class="font-bold text-slate-700">Error Page</h3>
            <p class="text-xs text-slate-500 mt-1">Simulación 404/500</p>
        </a>

    </div>

    <div class="mt-8">
        <a href="/" class="text-slate-400 hover:text-red-500 text-sm transition-colors">
            <i class="fa-solid fa-right-from-bracket"></i> Salir
        </a>
    </div>
@endsection