@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8">

    {{-- HEADER --}}
    <div class="mb-10 text-center sm:text-left">
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">
            Bienvenido al Sistema
        </h1>
        <p class="text-slate-500">
            Selecciona una herramienta:
        </p>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        {{-- CLICKER --}}
        <a href="{{ route('clicker') }}"
           class="group p-6 bg-white border border-slate-200 rounded-xl shadow-sm
                  hover:shadow-md hover:border-indigo-500 transition-all
                  focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <div class="text-indigo-500 text-3xl mb-3 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <h3 class="font-bold text-slate-700">Clicker</h3>
            <p class="text-sm text-slate-500 mt-1">Registrar datos</p>
        </a>

        {{-- CALCULADORA --}}
        <a href="{{ route('calculadora') }}"
           class="group p-6 bg-white border border-slate-200 rounded-xl shadow-sm
                  hover:shadow-md hover:border-emerald-500 transition-all
                  focus:outline-none focus:ring-2 focus:ring-emerald-500">
            <div class="text-emerald-500 text-3xl mb-3 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <h3 class="font-bold text-slate-700">Calculadora</h3>
            <p class="text-sm text-slate-500 mt-1">Operaciones básicas</p>
        </a>

        {{-- GALERÍA --}}
        <a href="{{ route('carrusel') }}"
           class="group p-6 bg-white border border-slate-200 rounded-xl shadow-sm
                  hover:shadow-md hover:border-amber-500 transition-all
                  focus:outline-none focus:ring-2 focus:ring-amber-500">
            <div class="text-amber-500 text-3xl mb-3 group-hover:scale-110 transition-transform">
                <i class="fa-regular fa-images"></i>
            </div>
            <h3 class="font-bold text-slate-700">Galería</h3>
            <p class="text-sm text-slate-500 mt-1">Carrusel de fotos</p>
        </a>

        {{-- EMPLEADOS --}}
        <a href="{{ route('empleados') }}"
           class="group p-6 bg-white border border-slate-200 rounded-xl shadow-sm
                  hover:shadow-md hover:border-violet-500 transition-all
                  focus:outline-none focus:ring-2 focus:ring-violet-500">
            <div class="text-violet-500 text-3xl mb-3 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3 class="font-bold text-slate-700">Empleados</h3>
            <p class="text-sm text-slate-500 mt-1">
                CRUD con Fetch + DOM
            </p>
        </a>

        {{-- ERROR PAGE --}}
        <a href="{{ route('error.demo') }}"
           class="group p-6 bg-white border border-slate-200 rounded-xl shadow-sm
                  hover:shadow-md hover:border-red-500 transition-all
                  focus:outline-none focus:ring-2 focus:ring-red-500">
            <div class="text-red-500 text-3xl mb-3 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-bug"></i>
            </div>
            <h3 class="font-bold text-slate-700">Error Page</h3>
            <p class="text-sm text-slate-500 mt-1">Simulación 404 / 500</p>
        </a>

    </div>

    {{-- FOOTER (LOGOUT SEGURO) --}}
    <div class="mt-10 text-center sm:text-left">
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <a href="#" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-red-500 text-sm transition-colors cursor-pointer">
            <i class="fa-solid fa-right-from-bracket"></i>
            Salir
        </a>
    </div>

</div>
@endsection