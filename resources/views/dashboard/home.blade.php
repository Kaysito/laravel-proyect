@extends('layout')

@section('title', 'Panel de Control')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">

    {{-- TOPBAR MODERNA (Con botón de Logout) --}}
    <div class="flex flex-col sm:flex-row justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8 gap-4">
        <div class="text-center sm:text-left">
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">
                Panel de Control
            </h1>
            <p class="text-slate-500 text-sm font-medium mt-1">
                Bienvenido de nuevo, <span class="text-indigo-600">{{ Auth::user()->name ?? 'Usuario' }}</span>
            </p>
        </div>

        {{-- BOTÓN DE LOGOUT (Formulario POST Seguro) --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                class="group flex items-center gap-2 bg-slate-50 hover:bg-red-50 text-slate-600 hover:text-red-600 font-bold py-2.5 px-5 rounded-xl transition-all duration-300 border border-slate-200 hover:border-red-200">
                <i class="fa-solid fa-power-off group-hover:scale-110 transition-transform"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>
    </div>

    {{-- GRID DE HERRAMIENTAS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- CLICKER --}}
        <a href="{{ route('clicker') }}"
           class="group block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-indigo-300 transition-all duration-300 hover:-translate-y-1">
            <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 text-2xl mb-4 group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-hand-pointer"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Clicker</h3>
            <p class="text-slate-500 text-sm mt-1 leading-relaxed">Herramienta rápida para registrar conteos y datos.</p>
        </a>

        {{-- CALCULADORA --}}
        <a href="{{ route('calculadora') }}"
           class="group block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-emerald-300 transition-all duration-300 hover:-translate-y-1">
            <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 text-2xl mb-4 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-calculator"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Calculadora</h3>
            <p class="text-slate-500 text-sm mt-1 leading-relaxed">Realiza operaciones matemáticas básicas al instante.</p>
        </a>

        {{-- GALERÍA --}}
        <a href="{{ route('carrusel') }}"
           class="group block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-amber-300 transition-all duration-300 hover:-translate-y-1">
            <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 text-2xl mb-4 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                <i class="fa-regular fa-images"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Galería Visual</h3>
            <p class="text-slate-500 text-sm mt-1 leading-relaxed">Administrador de imágenes tipo carrusel interactivo.</p>
        </a>

        {{-- EMPLEADOS --}}
        <a href="{{ route('empleados') }}"
           class="group block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-violet-300 transition-all duration-300 hover:-translate-y-1">
            <div class="w-14 h-14 bg-violet-50 rounded-xl flex items-center justify-center text-violet-500 text-2xl mb-4 group-hover:scale-110 group-hover:bg-violet-500 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-users-gear"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Directorio RRHH</h3>
            <p class="text-slate-500 text-sm mt-1 leading-relaxed">Gestión de empleados usando API Fetch y DOM dinámico.</p>
        </a>

        {{-- ERROR PAGE --}}
        <a href="{{ route('error.demo') }}"
           class="group block bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-rose-300 transition-all duration-300 hover:-translate-y-1">
            <div class="w-14 h-14 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 text-2xl mb-4 group-hover:scale-110 group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                <i class="fa-solid fa-bug"></i>
            </div>
            <h3 class="font-bold text-slate-800 text-lg">Simulador de Errores</h3>
            <p class="text-slate-500 text-sm mt-1 leading-relaxed">Prueba las vistas personalizadas de error 404 y 500.</p>
        </a>

        {{-- FORMULARIO PRO (Tarjeta Destacada) --}}
        <a href="{{ route('formulario') }}"
           class="group sm:col-span-2 lg:col-span-1 bg-gradient-to-br from-indigo-600 to-violet-700 p-6 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden flex flex-col justify-between">
            
            {{-- Adorno visual de fondo --}}
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-400 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white text-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <h3 class="font-bold text-white text-xl">Formulario Pro</h3>
                <p class="text-indigo-100 text-sm mt-2 leading-relaxed">
                    Experiencia avanzada con validación estricta y subida de archivos segura.
                </p>
            </div>
            
            <div class="relative z-10 mt-6 flex items-center text-white text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                Probar herramienta <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

    </div>
</div>
@endsection