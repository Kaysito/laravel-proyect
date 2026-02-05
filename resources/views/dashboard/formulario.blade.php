@extends('layout')

@section('breadcrumb', 'Formulario Profesional')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8">

    {{-- HEADER --}}
    <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">
            Formulario Profesional
        </h2>
        <p class="text-slate-500 text-sm sm:text-base">
            Este formulario valida correos de cualquier dominio válido, incluidos dominios nuevos y económicos.
        </p>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded">
            <strong>¡Correcto!</strong> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('formulario.validar') }}" method="POST" class="space-y-5" novalidate>
        @csrf

        {{-- NOMBRE --}}
        <div>
            <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">
                Nombre Completo <span class="text-red-500">*</span>
            </label>

            <input id="nombre"
                   type="text"
                   name="nombre"
                   value="{{ old('nombre') }}"
                   maxlength="50"
                   required
                   inputmode="text"
                   autocomplete="name"
                   pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                   oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g,'')"
                   aria-invalid="@error('nombre') true @else false @enderror"
                   class="w-full px-4 py-2 rounded-lg border transition
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                          @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror">

            @error('nombre')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                Correo Electrónico <span class="text-red-500">*</span>
            </label>

            <input id="email"
                   type="text"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   inputmode="email"
                   autocomplete="email"
                   pattern="^[^\s@]+@[^\s@]+\.[^\s@]{2,}$"
                   title="Ingresa un correo electrónico válido. Se aceptan todos los dominios."
                   placeholder="usuario@cualquier-dominio.fun"
                   aria-invalid="@error('email') true @else false @enderror"
                   class="w-full px-4 py-2 rounded-lg border transition
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                          @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror">

            <p class="text-xs text-slate-400 mt-1">
                Ejemplos válidos: .fun, .xyz, .lol, .ai, .io, .app, .online, etc.
            </p>

            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- FECHA --}}
        <div>
            <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">
                Fecha de Nacimiento <span class="text-red-500">*</span>
            </label>

            <input id="fecha_nacimiento"
                   type="date"
                   name="fecha_nacimiento"
                   value="{{ old('fecha_nacimiento') }}"
                   max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                   required
                   aria-invalid="@error('fecha_nacimiento') true @else false @enderror"
                   class="w-full px-4 py-2 rounded-lg border transition
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                          @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">

            @error('fecha_nacimiento')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- SITIO WEB --}}
        <div>
            <label for="sitio_web" class="block text-sm font-medium text-slate-700 mb-1">
                Sitio Web (Opcional)
            </label>

            <input id="sitio_web"
                   type="url"
                   name="sitio_web"
                   value="{{ old('sitio_web') }}"
                   placeholder="https://mi-sitio.barato"
                   inputmode="url"
                   class="w-full px-4 py-2 rounded-lg border transition
                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                          border-slate-300">

            @error('sitio_web')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- MENSAJE --}}
        <div>
            <label for="mensaje" class="block text-sm font-medium text-slate-700 mb-1">
                Mensaje <span class="text-red-500">*</span>
            </label>

            <textarea id="mensaje"
                      name="mensaje"
                      rows="4"
                      maxlength="255"
                      required
                      aria-invalid="@error('mensaje') true @else false @enderror"
                      class="w-full px-4 py-2 rounded-lg border transition resize-none
                             focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                             @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror">{{ old('mensaje') }}</textarea>

            <p class="text-xs text-slate-400 mt-1">
                Máximo 255 caracteres.
            </p>

            @error('mensaje')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- BOTÓN --}}
        <button type="submit"
                class="w-full bg-slate-800 hover:bg-slate-900 active:scale-[0.98]
                       transition transform text-white font-semibold py-3 rounded-lg shadow-lg">
            Enviar Formulario
        </button>
    </form>

    <a href="{{ route('home') }}"
       class="mt-6 inline-block text-slate-500 hover:text-slate-800 text-sm">
        ← Volver al menú
    </a>
</div>
@endsection
