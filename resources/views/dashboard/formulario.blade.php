@extends('layout')

@section('breadcrumb', 'Formulario Profesional')

@section('content')
    <div class="text-left">
        <h2 class="text-2xl font-bold text-slate-800 mb-2">Contacto Avanzado</h2>
        <p class="text-slate-500 mb-6 text-sm">Este formulario valida tus datos estrictamente antes de procesarlos.</p>

        @if(session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r">
                <p class="font-bold">¡Correcto!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('formulario.validar') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre') }}" 
                           maxlength="50"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                           placeholder="Ej. Juan Pérez">
                    <div class="absolute right-2 top-2 text-xs text-slate-400">Máx 50</div>
                </div>
                @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                           placeholder="hola@ejemplo.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="edad" class="block text-sm font-medium text-slate-700 mb-1">Edad <span class="text-red-500">*</span></label>
                    <input type="number" name="edad" id="edad" 
                           value="{{ old('edad') }}" min="18" max="100"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('edad') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                    @error('edad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                       value="{{ old('fecha_nacimiento') }}"
                       max="{{ date('Y-m-d') }}" 
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                <p class="text-xs text-slate-400 mt-1">Usa el calendario, no escribas manual.</p>
                @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sitio_web" class="block text-sm font-medium text-slate-700 mb-1">Sitio Web (Opcional)</label>
                <input type="url" name="sitio_web" id="sitio_web" 
                       value="{{ old('sitio_web') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-300"
                       placeholder="https://mi-sitio.com">
                @error('sitio_web') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="mensaje" class="block text-sm font-medium text-slate-700 mb-1">Mensaje <span class="text-red-500">*</span></label>
                <textarea name="mensaje" id="mensaje" rows="3" maxlength="255"
                          class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                          placeholder="Escribe tu consulta aquí...">{{ old('mensaje') }}</textarea>
                <div class="text-right text-xs text-slate-400">Máx 255 caracteres</div>
                @error('mensaje') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-lg transition shadow-lg flex justify-center items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Validar Datos
                </button>
            </div>
        </form>

        <a href="{{ route('home') }}" class="mt-6 inline-block text-slate-500 hover:text-slate-800 text-sm">
            <i class="fa-solid fa-arrow-left"></i> Volver al menú
        </a>
    </div>
@endsection