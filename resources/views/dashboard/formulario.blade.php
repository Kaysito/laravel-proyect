@extends('layout')

@section('breadcrumb', 'Dashboard / Formulario Profesional')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-slate-800">Formulario Profesional</h1>
        <p class="text-slate-500 mt-2">Rellena tus datos de manera precisa. Algunos campos son obligatorios.</p>
    </div>

    {{-- ================== MENSAJES ================== --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-8">
            <strong>¡Correcto!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- ================== FORMULARIO MULTIFACE ================== --}}
    <form action="{{ route('formulario.validar') }}" method="POST" class="space-y-6" novalidate>
        @csrf

        {{-- ---------------- FACE 1: Datos personales ---------------- --}}
        <div class="bg-white p-6 rounded-3xl shadow-md">
            <h2 class="text-xl font-semibold mb-4">Datos Personales</h2>

            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" 
                       value="{{ old('nombre') }}" maxlength="50"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                       placeholder="Ej. Juan Pérez">
                @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                       value="{{ old('fecha_nacimiento') }}" max="{{ date('Y-m-d') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                <p class="text-xs text-slate-400 mt-1">Tu edad se calculará automáticamente desde la fecha de nacimiento.</p>
                @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                       placeholder="hola@ejemplo.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ---------------- FACE 2: Datos opcionales ---------------- --}}
        <div class="bg-white p-6 rounded-3xl shadow-md">
            <h2 class="text-xl font-semibold mb-4">Datos Opcionales</h2>

            <div class="mb-4">
                <label for="sitio_web" class="block text-sm font-medium text-slate-700 mb-1">Sitio Web</label>
                <input type="url" name="sitio_web" id="sitio_web" 
                       value="{{ old('sitio_web') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-300"
                       placeholder="https://mi-sitio.com">
                @error('sitio_web') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="mensaje" class="block text-sm font-medium text-slate-700 mb-1">Mensaje <span class="text-red-500">*</span></label>
                <textarea name="mensaje" id="mensaje" rows="4" maxlength="255"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                          placeholder="Escribe tu consulta aquí...">{{ old('mensaje') }}</textarea>
                <div class="text-right text-xs text-slate-400">Máx 255 caracteres</div>
                @error('mensaje') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- ---------------- FACE 3: Botón enviar ---------------- --}}
        <div class="text-center">
            <button type="submit" class="w-full md:w-1/2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg flex justify-center items-center gap-2 mx-auto">
                <i class="fa-solid fa-paper-plane"></i> Enviar Formulario
            </button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-800 inline-flex items-center gap-1 text-sm">
            <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>
@endsection
