@extends('layout')

@section('breadcrumb', 'Formulario Profesional')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10">

        {{-- HEADER --}}
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Formulario Profesional
            </h2>
            <p class="text-slate-500 mt-1">
                Acepta correos de cualquier dominio válido (.fun, .shop, .xyz, .lol, etc.)
            </p>
        </div>

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                <strong>✔ Éxito:</strong> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('formulario.validar') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-6" novalidate>
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nombre completo <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       required
                       maxlength="50"
                       autocomplete="name"
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                              @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                @error('nombre')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       placeholder="usuario@dominio.fun"
                       pattern="^[^\s@]+@[^\s@]+\.[^\s@]{2,}$"
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                              @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                <p class="text-xs text-slate-400 mt-1">
                    Dominios modernos permitidos (.fun, .shop, .xyz, .online…)
                </p>
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- FECHA --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Fecha de nacimiento <span class="text-red-500">*</span>
                </label>
                <input type="date"
                       name="fecha_nacimiento"
                       value="{{ old('fecha_nacimiento') }}"
                       required
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                              @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                @error('fecha_nacimiento')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- SITIO WEB --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Sitio web (opcional)
                </label>
                <input type="url"
                       name="sitio_web"
                       value="{{ old('sitio_web') }}"
                       placeholder="https://mi-sitio.shop"
                       class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none border-slate-300">
                @error('sitio_web')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- MENSAJE --}}
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Mensaje <span class="text-red-500">*</span>
                </label>
                <textarea name="mensaje"
                          rows="4"
                          maxlength="255"
                          required
                          class="w-full rounded-lg border px-4 py-2 resize-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                                 @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror">{{ old('mensaje') }}</textarea>
                <div class="flex justify-between text-xs text-slate-400 mt-1">
                    <span>Máx. 255 caracteres</span>
                </div>
                @error('mensaje')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- BOTÓN --}}
            <div class="sm:col-span-2 pt-4">
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98]
                               transition text-white font-semibold py-3 rounded-xl shadow">
                    Enviar formulario
                </button>
            </div>
        </form>

        <div class="mt-6">
            <a href="{{ route('home') }}"
               class="text-sm text-slate-500 hover:text-slate-800">
                ← Volver al menú
            </a>
        </div>

    </div>
</div>
@endsection
