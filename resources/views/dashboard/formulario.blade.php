@extends('layout')

@section('breadcrumb', 'Formulario Profesional')

@section('content')
<div class="text-left max-w-3xl mx-auto py-8 px-4">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Formulario Profesional</h2>
        <p class="text-slate-500 mb-6 text-sm">Este formulario valida tus datos estrictamente antes de procesarlos.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded">
            <strong>¡Correcto!</strong> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('formulario.validar') }}" method="POST" class="space-y-4" novalidate>
        @csrf

        {{-- ================== NOMBRE ================== --}}
        <div>
            <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">
                Nombre Completo <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nombre" id="nombre"
                   value="{{ old('nombre') }}"
                   maxlength="50"
                   pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                   title="Solo letras y espacios"
                   oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g,'')"
                   required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                   placeholder="Ej. Juan Pérez">
            <p class="text-xs text-slate-400 mt-1">Máx 50 caracteres, solo letras y espacios</p>
            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ================== EMAIL ================== --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                Correo Electrónico <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}"
                   required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                   placeholder="hola@ejemplo.com">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ================== FECHA DE NACIMIENTO ================== --}}
        <div>
            <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">
                Fecha de Nacimiento <span class="text-red-500">*</span>
            </label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                   value="{{ old('fecha_nacimiento') }}"
                   max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                   required
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">
            <p class="text-xs text-slate-400 mt-1">Debes ser mayor de 18 años</p>
            @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ================== SITIO WEB OPCIONAL ================== --}}
        <div>
            <label for="sitio_web" class="block text-sm font-medium text-slate-700 mb-1">
                Sitio Web (Opcional)
            </label>
            <input type="url" name="sitio_web" id="sitio_web"
                   value="{{ old('sitio_web') }}"
                   placeholder="https://mi-sitio.com"
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-300">
            @error('sitio_web') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ================== MENSAJE ================== --}}
        <div>
            <label for="mensaje" class="block text-sm font-medium text-slate-700 mb-1">
                Mensaje <span class="text-red-500">*</span>
            </label>
            <textarea name="mensaje" id="mensaje" rows="4" maxlength="255"
                      required
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                      placeholder="Escribe tu consulta aquí...">{{ old('mensaje') }}</textarea>
            <div class="text-right text-xs text-slate-400">Máx 255 caracteres</div>
            @error('mensaje') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ================== BOTÓN ================== --}}
        <div>
            <button type="submit" 
                    class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-lg transition shadow-lg flex justify-center items-center gap-2">
                <i class="fa-solid fa-paper-plane"></i> Enviar Formulario
            </button>
        </div>
    </form>

    <a href="{{ route('home') }}" class="mt-6 inline-block text-slate-500 hover:text-slate-800 text-sm">
        <i class="fa-solid fa-arrow-left"></i> Volver al menú
    </a>
</div>
@endsection
