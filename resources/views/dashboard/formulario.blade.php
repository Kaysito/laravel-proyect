@extends('layout')

@section('breadcrumb', 'Inicio > Dashboard / Formulario Profesional')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">

    {{-- ================== HEADER ================== --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-slate-800">Formulario Profesional Multietapa</h1>
        <p class="text-slate-500 mt-2">Completa cada sección para enviar tu formulario correctamente.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded mb-6">
            <strong>¡Correcto!</strong> {{ session('success') }}
        </div>
    @endif

    <form id="multiStepForm" action="{{ route('formulario.validar') }}" method="POST" class="space-y-6">
        @csrf

        {{-- ================== STEP INDICATOR ================== --}}
        <div class="flex justify-between mb-6">
            <div class="step-indicator font-semibold text-sm text-slate-500" data-step="1">1. Datos Personales</div>
            <div class="step-indicator font-semibold text-sm text-slate-500" data-step="2">2. Ciudad / Contacto</div>
            <div class="step-indicator font-semibold text-sm text-slate-500" data-step="3">3. Opcionales</div>
            <div class="step-indicator font-semibold text-sm text-slate-500" data-step="4">4. Mensaje / Confirmación</div>
        </div>

        {{-- ---------------- STEP 1: Datos Personales ---------------- --}}
        <div class="form-step" data-step="1">
            <div class="bg-white p-6 rounded-3xl shadow-md space-y-4">
                <h2 class="text-xl font-semibold mb-2">Datos Personales</h2>

                <div>
                    <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" id="nombre" 
                           value="{{ old('nombre') }}" maxlength="50"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('nombre') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                           placeholder="Ej. Juan Pérez">
                    @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                           value="{{ old('fecha_nacimiento') }}" max="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('fecha_nacimiento') border-red-500 bg-red-50 @else border-slate-300 @enderror">
                    @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" class="next-step bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition">Siguiente</button>
                </div>
            </div>
        </div>

        {{-- ---------------- STEP 2: Ciudad / Contacto ---------------- --}}
        <div class="form-step hidden" data-step="2">
            <div class="bg-white p-6 rounded-3xl shadow-md space-y-4">
                <h2 class="text-xl font-semibold mb-2">Ciudad y Contacto</h2>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('email') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                           placeholder="hola@ejemplo.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ciudad" class="block text-sm font-medium text-slate-700 mb-1">Ciudad <span class="text-red-500">*</span></label>
                    <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-300"
                           placeholder="Ej. Ciudad de México">
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" class="prev-step bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg font-medium transition">Anterior</button>
                    <button type="button" class="next-step bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition">Siguiente</button>
                </div>
            </div>
        </div>

        {{-- ---------------- STEP 3: Opcionales ---------------- --}}
        <div class="form-step hidden" data-step="3">
            <div class="bg-white p-6 rounded-3xl shadow-md space-y-4">
                <h2 class="text-xl font-semibold mb-2">Datos Opcionales</h2>

                <div>
                    <label for="sitio_web" class="block text-sm font-medium text-slate-700 mb-1">Sitio Web</label>
                    <input type="url" name="sitio_web" id="sitio_web" 
                           value="{{ old('sitio_web') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-slate-300"
                           placeholder="https://mi-sitio.com">
                    @error('sitio_web') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" class="prev-step bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg font-medium transition">Anterior</button>
                    <button type="button" class="next-step bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-medium transition">Siguiente</button>
                </div>
            </div>
        </div>

        {{-- ---------------- STEP 4: Mensaje / Confirmación ---------------- --}}
        <div class="form-step hidden" data-step="4">
            <div class="bg-white p-6 rounded-3xl shadow-md space-y-4">
                <h2 class="text-xl font-semibold mb-2">Mensaje y Confirmación</h2>

                <div>
                    <label for="mensaje" class="block text-sm font-medium text-slate-700 mb-1">Mensaje <span class="text-red-500">*</span></label>
                    <textarea name="mensaje" id="mensaje" rows="4" maxlength="255"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none @error('mensaje') border-red-500 bg-red-50 @else border-slate-300 @enderror"
                              placeholder="Escribe tu consulta aquí...">{{ old('mensaje') }}</textarea>
                    <div class="text-right text-xs text-slate-400">Máx 255 caracteres</div>
                    @error('mensaje') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" class="prev-step bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg font-medium transition">Anterior</button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">Enviar Formulario</button>
                </div>
            </div>
        </div>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-800 inline-flex items-center gap-1 text-sm">
            <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

{{-- ================== JS MULTISTEP ================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const steps = document.querySelectorAll('.form-step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    let currentStep = 0;

    function showStep(step) {
        steps.forEach((s, i) => {
            s.classList.toggle('hidden', i !== step);
        });
        stepIndicators.forEach((ind, i) => {
            ind.classList.toggle('text-indigo-600', i === step);
            ind.classList.toggle('font-bold', i === step);
            ind.classList.toggle('text-slate-500', i !== step);
        });
        currentStep = step;
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if(currentStep < steps.length - 1) showStep(currentStep + 1);
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if(currentStep > 0) showStep(currentStep - 1);
        });
    });

    showStep(0); // mostrar primer paso al inicio
});
</script>
@endsection
