@extends('layout')

@section('breadcrumb', 'Formulario Profesional')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">

    {{-- CARD PRINCIPAL --}}
    <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10">

        {{-- HEADER --}}
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Formulario Profesional (AJAX)
            </h2>
            <p class="text-slate-500 mt-1">
                Los datos se guardan en BD y se muestran aquí sin recargar.
            </p>
        </div>

        {{-- ALERTAS GLOBALES (JS las manipulará) --}}
        <div id="alerta-exito" class="hidden mb-6 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
            <strong>✔ Éxito:</strong> <span id="msg-exito"></span>
        </div>

        {{-- FORMULARIO --}}
        {{-- Quitamos method y action del HTML estándar para usar JS, pero dejamos el action para leer la URL --}}
        <form id="ajaxForm" action="{{ route('formulario.validar') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-6" novalidate>
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nombre completo <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="nombre" 
                       id="nombre"
                       required 
                       maxlength="50"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                {{-- Contenedor de error JS --}}
                <p id="error-nombre" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email"
                       required 
                       placeholder="usuario@dominio.fun"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                <p class="text-xs text-slate-400 mt-1">
                    Dominios modernos permitidos (.fun, .shop, .xyz, .online…)
                </p>
                <p id="error-email" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- FECHA --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Fecha de nacimiento <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="fecha_nacimiento" 
                       id="fecha_nacimiento"
                       required 
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                <p id="error-fecha_nacimiento" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- SITIO WEB --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Sitio web (opcional)
                </label>
                <input type="url" 
                       name="sitio_web" 
                       id="sitio_web"
                       placeholder="https://mi-sitio.shop"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors">
                <p id="error-sitio_web" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- MENSAJE --}}
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Mensaje <span class="text-red-500">*</span>
                </label>
                <textarea name="mensaje" 
                          id="mensaje"
                          rows="4" 
                          maxlength="255" 
                          required 
                          class="w-full rounded-lg border border-slate-300 px-4 py-2 resize-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors"></textarea>
                <div class="flex justify-between text-xs text-slate-400 mt-1">
                    <span>Máx. 255 caracteres</span>
                </div>
                <p id="error-mensaje" class="text-xs text-red-500 mt-1 hidden"></p>
            </div>

            {{-- BOTÓN DE ENVÍO --}}
            <div class="sm:col-span-2 pt-4">
                <button type="submit" 
                        id="btn-submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] transition text-white font-semibold py-3 rounded-xl shadow flex justify-center items-center gap-2">
                    <span>Enviar formulario</span>
                    {{-- Spinner de carga (oculto por defecto) --}}
                    <svg id="spinner" class="animate-spin h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>

        {{-- LINKS --}}
        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-sm text-slate-500 hover:text-slate-800">
                ← Volver al menú
            </a>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- RESULTADO DOM (Inicialmente Oculto) --}}
    {{-- Aquí inyectaremos los datos que devuelve la BD --}}
    {{-- ========================================== --}}
    <div id="resultado-card" class="hidden mt-8 bg-indigo-50 rounded-2xl shadow-md border border-indigo-100 p-6 sm:p-10 transition-all duration-500">
        <div class="flex items-center gap-4 mb-4">
            <div class="bg-indigo-600 text-white rounded-full p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-indigo-900">Registro Guardado en BD</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 text-sm text-indigo-800">
            <p><strong>ID Generado:</strong> <span id="res-id" class="font-mono bg-white px-2 py-1 rounded border border-indigo-200"></span></p>
            <p><strong>Nombre:</strong> <span id="res-nombre"></span></p>
            <p><strong>Email:</strong> <span id="res-email"></span></p>
            <p><strong>Fecha Nac:</strong> <span id="res-fecha"></span></p>
            <div class="sm:col-span-2 mt-2 p-4 bg-white rounded-lg border border-indigo-100 italic">
                "<span id="res-mensaje"></span>"
            </div>
        </div>
    </div>

</div>

{{-- SCRIPT PARA FETCH Y DOM --}}
<script>
    document.getElementById('ajaxForm').addEventListener('submit', function(e) {
        e.preventDefault(); // 1. Evitar recarga

        // Elementos de UI
        const form = this;
        const btn = document.getElementById('btn-submit');
        const spinner = document.getElementById('spinner');
        const alertSuccess = document.getElementById('alerta-exito');
        const resultCard = document.getElementById('resultado-card');

        // Estado de carga visual
        btn.disabled = true;
        btn.classList.add('opacity-75');
        spinner.classList.remove('hidden');
        
        // Limpiar errores previos y ocultar resultados anteriores
        document.querySelectorAll('.text-red-500.text-xs').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('input, textarea').forEach(el => el.classList.remove('border-red-500', 'bg-red-50'));
        alertSuccess.classList.add('hidden');
        resultCard.classList.add('hidden');

        // Preparar datos
        const formData = new FormData(form);

        // 2. Fetch Request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest', // Indica que es AJAX
                // 'X-CSRF-TOKEN' ya va incluido si usas <input type="hidden" name="_token"> generado por @csrf
            }
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            
            // CASO A: VALIDACIÓN FALLIDA (Laravel devuelve 422)
            if (status === 422) {
                const errors = body.errors;
                for (const field in errors) {
                    // Mostrar mensaje de error
                    const errorText = document.getElementById(`error-${field}`);
                    const inputField = document.getElementById(field);
                    
                    if (errorText) {
                        errorText.innerText = errors[field][0];
                        errorText.classList.remove('hidden');
                    }
                    if (inputField) {
                        inputField.classList.add('border-red-500', 'bg-red-50');
                    }
                }
            } 
            // CASO B: ÉXITO (Status 200)
            else if (status === 200 && body.success) {
                // 1. Mostrar Alerta
                document.getElementById('msg-exito').innerText = body.message;
                alertSuccess.classList.remove('hidden');

                // 2. MANIPULACIÓN DOM: Rellenar la tarjeta con datos de la BD
                const datos = body.data;
                document.getElementById('res-id').innerText = '#' + datos.id;
                document.getElementById('res-nombre').innerText = datos.nombre;
                document.getElementById('res-email').innerText = datos.email;
                document.getElementById('res-fecha').innerText = datos.fecha;
                document.getElementById('res-mensaje').innerText = datos.mensaje;

                // 3. Mostrar tarjeta con animación simple
                resultCard.classList.remove('hidden');
                
                // 4. Resetear formulario
                form.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error crítico en el sistema');
        })
        .finally(() => {
            // Restaurar botón
            btn.disabled = false;
            btn.classList.remove('opacity-75');
            spinner.classList.add('hidden');
        });
    });
</script>
@endsection