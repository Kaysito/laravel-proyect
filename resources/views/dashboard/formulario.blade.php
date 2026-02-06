@extends('layout')

@section('title', 'Nuevo Contacto')
@section('breadcrumb', 'Formulario Profesional')

@section('content')
<div class="text-left"> {{-- Alineación a la izquierda para contrarrestar el center del layout --}}
    
    {{-- ALERTAS DE ESTADO (ocultas por defecto) --}}
    <div id="formAlert" class="hidden mb-6 rounded-md p-4 text-sm font-medium"></div>

    <form id="contactForm">
        @csrf
        <div class="space-y-12">
            
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Información de Contacto</h2>
                <p class="mt-1 text-sm/6 text-gray-600">Esta información será registrada en la base de datos de contactos.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    
                    <div class="sm:col-span-4">
                        <label for="sitio_web" class="block text-sm/6 font-medium text-gray-900">Sitio Web</label>
                        <div class="mt-2">
                            <div class="flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">https://</div>
                                <input type="text" name="sitio_web" id="sitio_web" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" placeholder="tu-sitio.com">
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="mensaje" class="block text-sm/6 font-medium text-gray-900">Mensaje / Acerca de</label>
                        <div class="mt-2">
                            <textarea name="mensaje" id="mensaje" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required></textarea>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Escribe aquí los detalles de la consulta o mensaje principal.</p>
                    </div>

                    <div class="col-span-full">
                        <label class="block text-sm/6 font-medium text-gray-900">Avatar</label>
                        <div class="mt-2 flex items-center gap-x-3">
                            <div class="h-12 w-12 text-gray-300">
                                <svg class="h-12 w-12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653Zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438ZM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <button type="button" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50">Cambiar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Datos Personales</h2>
                <p class="mt-1 text-sm/6 text-gray-600">Información necesaria para validar el registro.</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    
                    <div class="sm:col-span-3">
                        <label for="nombre" class="block text-sm/6 font-medium text-gray-900">Nombre Completo</label>
                        <div class="mt-2">
                            <input type="text" name="nombre" id="nombre" autocomplete="given-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="fecha_nacimiento" class="block text-sm/6 font-medium text-gray-900">Fecha de Nacimiento</label>
                        <div class="mt-2">
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="email" class="block text-sm/6 font-medium text-gray-900">Dirección de Email</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" required>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="country" class="block text-sm/6 font-medium text-gray-900">País</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="country" name="country" autocomplete="country-name" class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option>México</option>
                                <option>Estados Unidos</option>
                                <option>Canadá</option>
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" onclick="window.location.reload()" class="text-sm/6 font-semibold text-gray-900">Cancelar</button>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Guardar Contacto
                </button>
            </div>
        </div>
    </form>
    
    <div class="mt-12 border-t border-gray-200 pt-10">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Últimos Contactos Agregados</h3>
        <div class="overflow-hidden bg-white shadow sm:rounded-md ring-1 ring-gray-200">
            <ul role="list" class="divide-y divide-gray-200" id="contactsList">
                <li class="px-4 py-4 sm:px-6 text-center text-gray-500 text-sm" id="emptyState">
                    No hay contactos recientes.
                </li>
            </ul>
        </div>
    </div>

</div>

{{-- SCRIPT JAVASCRIPT PARA EL FETCH --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('contactForm');
        const alertBox = document.getElementById('formAlert');
        const listContainer = document.getElementById('contactsList');
        const emptyState = document.getElementById('emptyState');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);

            fetch("{{ route('validar.formulario') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar éxito (Estilo Tailwind Green)
                    alertBox.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'ring-red-600/20');
                    alertBox.classList.add('block', 'bg-green-50', 'text-green-700', 'ring-1', 'ring-inset', 'ring-green-600/20');
                    alertBox.textContent = data.message;

                    // Agregar a la lista visualmente
                    if(emptyState) emptyState.style.display = 'none';

                    const item = `
                        <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 animate-pulse">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">${data.data.nombre}</p>
                                    <p class="mt-1 flex text-xs leading-5 text-gray-500">${data.data.email}</p>
                                </div>
                            </div>
                            <div class="flex shrink-0 items-center gap-x-4">
                                <div class="hidden sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm leading-6 text-gray-900">ID: ${data.data.id}</p>
                                    <p class="mt-1 text-xs leading-5 text-gray-500">Recién Agregado</p>
                                </div>
                            </div>
                        </li>
                    `;
                    listContainer.insertAdjacentHTML('afterbegin', item);
                    
                    // Quitar animación de pulso tras un momento
                    setTimeout(() => {
                        listContainer.firstElementChild.classList.remove('animate-pulse');
                    }, 1000);

                    form.reset();
                } else {
                    throw new Error(data.message || 'Error desconocido');
                }
            })
            .catch(error => {
                // Mostrar Error (Estilo Tailwind Red)
                alertBox.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'ring-green-600/20');
                alertBox.classList.add('block', 'bg-red-50', 'text-red-700', 'ring-1', 'ring-inset', 'ring-red-600/20');
                alertBox.textContent = error.message || 'Hubo un error al guardar.';
            });
        });
    });
</script>
@endsection