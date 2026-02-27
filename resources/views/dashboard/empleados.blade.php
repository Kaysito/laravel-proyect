@extends('layout')

@section('title', 'Gestión de Empleados')
@section('breadcrumb', 'Lista de Empleados')

@section('content')
    <div class="space-y-6 text-left">
        
        {{-- Encabezado --}}
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-bold text-slate-800">Directorio</h2>
            <p class="text-slate-500 text-sm">Gestiona los empleados de la plataforma.</p>
        </div>

        {{-- 1. FORMULARIO --}}
        <form id="empleadoForm" class="bg-slate-50 p-6 rounded-lg border border-slate-200 shadow-sm relative transition-colors duration-300">
            
            {{-- Título dinámico del formulario --}}
            <h3 id="formTitle" class="text-sm font-bold text-indigo-600 mb-4 uppercase tracking-wide">
                <i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado
            </h3>

            {{-- Input oculto para guardar el ID cuando editamos --}}
            <input type="hidden" id="editId">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Nombre</label>
                    <input type="text" name="nombre" id="inputNombre" placeholder="Ej. Juan Pérez" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Email</label>
                    <input type="email" name="email" id="inputEmail" placeholder="juan@ejemplo.com" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Cargo</label>
                    <input type="text" name="cargo" id="inputCargo" placeholder="Ej. Desarrollador" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="flex justify-end gap-2">
                {{-- Botón Cancelar (Oculto por defecto) --}}
                <button type="button" id="btnCancelar" onclick="resetearFormulario()"
                    class="hidden bg-slate-300 hover:bg-slate-400 text-slate-700 font-semibold py-2 px-6 rounded shadow transition-colors">
                    Cancelar
                </button>

                {{-- Botón Guardar --}}
                <button type="submit" id="btnSubmit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded shadow transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Empleado
                </button>
            </div>
        </form>

        {{-- 2. TABLA --}}
        <div class="overflow-hidden rounded-lg border @extends('layout')

@section('title', 'Gestión de Empleados')
@section('breadcrumb', 'Lista de Empleados')

@section('content')
    <div class="space-y-6 text-left">
        
        {{-- Encabezado --}}
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-bold text-slate-800">Directorio</h2>
            <p class="text-slate-500 text-sm">Gestiona los empleados de la plataforma.</p>
        </div>

        {{-- 1. FORMULARIO --}}
        <form id="empleadoForm" class="bg-slate-50 p-6 rounded-lg border border-slate-200 shadow-sm relative transition-colors duration-300">
            
            {{-- Título dinámico del formulario --}}
            <h3 id="formTitle" class="text-sm font-bold text-indigo-600 mb-4 uppercase tracking-wide">
                <i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado
            </h3>

            {{-- Input oculto para guardar el ID cuando editamos --}}
            <input type="hidden" id="editId">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Nombre</label>
                    <input type="text" name="nombre" id="inputNombre" placeholder="Ej. Juan Pérez" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Email</label>
                    <input type="email" name="email" id="inputEmail" placeholder="juan@ejemplo.com" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Cargo</label>
                    <input type="text" name="cargo" id="inputCargo" placeholder="Ej. Desarrollador" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            <div class="flex justify-end gap-2">
                {{-- Botón Cancelar (Oculto por defecto) --}}
                <button type="button" id="btnCancelar" onclick="resetearFormulario()"
                    class="hidden bg-slate-300 hover:bg-slate-400 text-slate-700 font-semibold py-2 px-6 rounded shadow transition-colors">
                    Cancelar
                </button>

                {{-- Botón Guardar --}}
                <button type="submit" id="btnSubmit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded shadow transition-colors flex items-center justify-center">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Empleado
                </button>
            </div>
        </form>

        {{-- 2. TABLA --}}
        <div class="overflow-hidden rounded-lg border border-slate-200 shadow-sm">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-slate-700 uppercase font-bold text-xs">
                    <tr>
                        <th class="p-4">Nombre</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Cargo</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="empleadosBody" class="divide-y divide-slate-200 bg-white">
                    {{-- JS llena esto --}}
                </tbody>
            </table>
            
            {{-- 3. CONTROLES DE PAGINACIÓN (Agregado) --}}
            <div id="paginacionControles" class="bg-white px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6 hidden">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-700">
                            Mostrando <span id="infoInicio" class="font-medium"></span> a <span id="infoFin" class="font-medium"></span> de <span id="infoTotal" class="font-medium"></span> resultados
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="paginacionBotones">
                            {{-- JS genera los botones aquí --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
<script>
let editMode = false;
let todosLosEmpleados = []; // Aquí guardaremos todos los datos
let paginaActual = 1;
const empleadosPorPagina = 10; // Límite de empleados por vista

document.addEventListener('DOMContentLoaded', () => {
    cargarEmpleados();

    const form = document.getElementById('empleadoForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async e => {
        e.preventDefault();
        
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Procesando...';
        btn.disabled = true;

        const formData = new FormData(form);
        const dataObject = Object.fromEntries(formData);
        
        let url = '/api/empleados';
        let method = 'POST';

        if (editMode) {
            const id = document.getElementById('editId').value;
            url = `/api/empleados/${id}`;
            method = 'PUT';
        }

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(dataObject)
            });

            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Error en la petición');
            }

            await cargarEmpleados(); 
            resetearFormulario();

        } catch (error) {
            console.error(error);
            alert('Error: ' + error.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
});

async function cargarEmpleados() {
    try {
        const res = await fetch('/api/empleados');
        todosLosEmpleados = await res.json();
        renderizarTabla(); // Llamamos a la nueva función que maneja la paginación
    } catch (error) { console.error(error); }
}

function renderizarTabla() {
    const tbody = document.getElementById('empleadosBody');
    tbody.innerHTML = ''; 

    // 1. Calcular índices para la página actual
    const indiceInicio = (paginaActual - 1) * empleadosPorPagina;
    const indiceFin = indiceInicio + empleadosPorPagina;
    
    // 2. Extraer solo los empleados de esta página
    const empleadosPagina = todosLosEmpleados.slice(indiceInicio, indiceFin);

    // 3. Renderizar filas
    empleadosPagina.forEach(agregarFila);

    // 4. Actualizar controles de paginación
    actualizarPaginacion();
}

function agregarFila(emp) {
    const tr = document.createElement('tr');
    tr.className = "hover:bg-slate-50 transition-colors";
    
    // Escapar comillas simples para evitar errores en las funciones onclick
    const nombreEscapado = emp.nombre.replace(/'/g, "\\'");
    const emailEscapado = emp.email.replace(/'/g, "\\'");
    const cargoEscapado = emp.cargo.replace(/'/g, "\\'");

    tr.innerHTML = `
        <td class="p-4 font-medium text-slate-900">${emp.nombre}</td>
        <td class="p-4">${emp.email}</td>
        <td class="p-4">
            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold">${emp.cargo}</span>
        </td>
        <td class="p-4 text-center space-x-2">
            <button class="text-amber-500 hover:text-amber-700 hover:bg-amber-50 p-2 rounded-full transition"
                onclick="prepararEdicion(${emp.id}, '${nombreEscapado}', '${emailEscapado}', '${cargoEscapado}')"
                title="Editar">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition" 
                onclick="eliminarEmpleado(${emp.id})"
                title="Eliminar">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;
    tbody.appendChild(tr); // Usamos appendChild porque la lista ya viene ordenada del backend
}

function actualizarPaginacion() {
    const totalEmpleados = todosLosEmpleados.length;
    const totalPaginas = Math.ceil(totalEmpleados / empleadosPorPagina);
    const contenedorPaginacion = document.getElementById('paginacionControles');
    const botonesContainer = document.getElementById('paginacionBotones');

    // Ocultar paginación si hay 10 o menos empleados
    if (totalEmpleados <= empleadosPorPagina) {
        contenedorPaginacion.classList.add('hidden');
        return;
    }

    contenedorPaginacion.classList.remove('hidden');
    botonesContainer.innerHTML = '';

    // Actualizar texto de información ("Mostrando 1 a 10 de 50")
    const inicio = (paginaActual - 1) * empleadosPorPagina + 1;
    const fin = Math.min(paginaActual * empleadosPorPagina, totalEmpleados);
    document.getElementById('infoInicio').innerText = inicio;
    document.getElementById('infoFin').innerText = fin;
    document.getElementById('infoTotal').innerText = totalEmpleados;

    // Crear botón "Anterior"
    const btnAnterior = crearBotonPaginacion('Anterior', paginaActual > 1 ? paginaActual - 1 : 1, paginaActual === 1);
    botonesContainer.appendChild(btnAnterior);

    // Crear botones numerados
    for (let i = 1; i <= totalPaginas; i++) {
        const btnNumero = crearBotonPaginacion(i, i, false, i === paginaActual);
        botonesContainer.appendChild(btnNumero);
    }

    // Crear botón "Siguiente"
    const btnSiguiente = crearBotonPaginacion('Siguiente', paginaActual < totalPaginas ? paginaActual + 1 : totalPaginas, paginaActual === totalPaginas);
    botonesContainer.appendChild(btnSiguiente);
}

function crearBotonPaginacion(texto, paginaDestino, deshabilitado = false, activo = false) {
    const btn = document.createElement('button');
    btn.innerHTML = texto;
    
    // Estilos base de Tailwind
    let clasesBase = "relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors ";
    
    if (deshabilitado) {
        clasesBase += "border-slate-300 text-slate-300 bg-slate-50 cursor-not-allowed";
        btn.disabled = true;
    } else if (activo) {
        clasesBase += "z-10 bg-indigo-50 border-indigo-500 text-indigo-600 cursor-default";
    } else {
        clasesBase += "bg-white border-slate-300 text-slate-500 hover:bg-slate-50 cursor-pointer";
        btn.onclick = () => {
            paginaActual = paginaDestino;
            renderizarTabla();
        };
    }

    // Redondear bordes del primer y último elemento (opcional para estética)
    if(texto === 'Anterior') clasesBase += " rounded-l-md";
    if(texto === 'Siguiente') clasesBase += " rounded-r-md";

    btn.className = clasesBase;
    return btn;
}

// ... (El resto de funciones: prepararEdicion, resetearFormulario se mantienen igual) ...
function prepararEdicion(id, nombre, email, cargo) {
    editMode = true;
    document.getElementById('editId').value = id;
    document.getElementById('inputNombre').value = nombre;
    document.getElementById('inputEmail').value = email;
    document.getElementById('inputCargo').value = cargo;

    const form = document.getElementById('empleadoForm');
    form.classList.remove('bg-slate-50', 'border-slate-200');
    form.classList.add('bg-amber-50', 'border-amber-200'); 

    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-pen-to-square mr-1"></i> Editando Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-amber-600 mb-4 uppercase tracking-wide";

    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Actualizar';
    btnSubmit.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.add('bg-amber-600', 'hover:bg-amber-700');

    document.getElementById('btnCancelar').classList.remove('hidden');
    form.scrollIntoView({ behavior: 'smooth' });
}

function resetearFormulario() {
    editMode = false;
    document.getElementById('empleadoForm').reset();
    document.getElementById('editId').value = '';

    const form = document.getElementById('empleadoForm');
    form.classList.add('bg-slate-50', 'border-slate-200');
    form.classList.remove('bg-amber-50', 'border-amber-200');

    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-indigo-600 mb-4 uppercase tracking-wide";

    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Guardar Empleado';
    btnSubmit.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.remove('bg-amber-600', 'hover:bg-amber-700');

    document.getElementById('btnCancelar').classList.add('hidden');
}

async function eliminarEmpleado(id) {
    if(!confirm('¿Estás seguro de eliminar este empleado?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try {
        const res = await fetch(`/api/empleados/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        if (res.ok) {
            // Si al eliminar, la página actual se queda vacía, retrocedemos una página
            if (todosLosEmpleados.length % empleadosPorPagina === 1 && paginaActual > 1) {
                paginaActual--;
            }
            await cargarEmpleados(); 
        }
    } catch (error) { console.error(error); }
}
</script>
@endsectionborder-slate-200 shadow-sm">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-slate-700 uppercase font-bold text-xs">
                    <tr>
                        <th class="p-4">Nombre</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Cargo</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="empleadosBody" class="divide-y divide-slate-200 bg-white">
                    {{-- JS llena esto --}}
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('scripts')
<script>
let editMode = false; // Variable para saber si estamos editando o creando

document.addEventListener('DOMContentLoaded', () => {
    cargarEmpleados();

    const form = document.getElementById('empleadoForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    form.addEventListener('submit', async e => {
        e.preventDefault();
        
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Procesando...';
        btn.disabled = true;

        const formData = new FormData(form);
        const dataObject = Object.fromEntries(formData); // Convertir FormData a objeto JSON
        
        let url = '/api/empleados';
        let method = 'POST';

        // Si estamos en MODO EDICIÓN, cambiamos la URL y el Método
        if (editMode) {
            const id = document.getElementById('editId').value;
            url = `/api/empleados/${id}`;
            method = 'PUT';
            // Laravel PUT necesita los datos en formato URL-encoded o JSON raw, FormData a veces falla con PUT directo
            // Así que usaremos JSON Body
        }

        try {
            const res = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json', // Importante para el PUT
                    'Accept': 'application/json'
                },
                body: JSON.stringify(dataObject)
            });

            if (!res.ok) {
                const errorData = await res.json();
                throw new Error(errorData.message || 'Error en la petición');
            }

            // Recargar toda la lista para ver los cambios frescos
            await cargarEmpleados(); 
            resetearFormulario();

        } catch (error) {
            console.error(error);
            alert('Error: ' + error.message);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
});

async function cargarEmpleados() {
    try {
        const res = await fetch('/api/empleados');
        const empleados = await res.json();
        document.getElementById('empleadosBody').innerHTML = ''; 
        empleados.forEach(agregarFila);
    } catch (error) { console.error(error); }
}

function agregarFila(emp) {
    const tr = document.createElement('tr');
    tr.className = "hover:bg-slate-50 transition-colors";
    // Ojo: Pasamos los datos con comillas escapadas para evitar errores
    tr.innerHTML = `
        <td class="p-4 font-medium text-slate-900">${emp.nombre}</td>
        <td class="p-4">${emp.email}</td>
        <td class="p-4">
            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold">${emp.cargo}</span>
        </td>
        <td class="p-4 text-center space-x-2">
            
            {{-- BOTÓN EDITAR (Lápiz) --}}
            <button class="text-amber-500 hover:text-amber-700 hover:bg-amber-50 p-2 rounded-full transition"
                onclick="prepararEdicion(${emp.id}, '${emp.nombre}', '${emp.email}', '${emp.cargo}')"
                title="Editar">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>

            {{-- BOTÓN ELIMINAR (Basura) --}}
            <button class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition" 
                onclick="eliminarEmpleado(${emp.id}, this)"
                title="Eliminar">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;
    document.getElementById('empleadosBody').prepend(tr); // Usamos prepend para que los nuevos salgan arriba
}

// Función que sube los datos de la tabla al formulario
function prepararEdicion(id, nombre, email, cargo) {
    // 1. Activar modo edición
    editMode = true;
    document.getElementById('editId').value = id;

    // 2. Rellenar inputs
    document.getElementById('inputNombre').value = nombre;
    document.getElementById('inputEmail').value = email;
    document.getElementById('inputCargo').value = cargo;

    // 3. Cambiar UI (Color del formulario y botones)
    const form = document.getElementById('empleadoForm');
    form.classList.remove('bg-slate-50', 'border-slate-200');
    form.classList.add('bg-amber-50', 'border-amber-200'); // Color amarillito para indicar edición

    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-pen-to-square mr-1"></i> Editando Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-amber-600 mb-4 uppercase tracking-wide";

    // Cambiar botón guardar
    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Actualizar';
    btnSubmit.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.add('bg-amber-600', 'hover:bg-amber-700');

    // Mostrar botón cancelar
    document.getElementById('btnCancelar').classList.remove('hidden');

    // Scroll suave hacia el formulario
    form.scrollIntoView({ behavior: 'smooth' });
}

// Función para volver al estado normal
function resetearFormulario() {
    editMode = false;
    document.getElementById('empleadoForm').reset();
    document.getElementById('editId').value = '';

    // Restaurar UI
    const form = document.getElementById('empleadoForm');
    form.classList.add('bg-slate-50', 'border-slate-200');
    form.classList.remove('bg-amber-50', 'border-amber-200');

    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-indigo-600 mb-4 uppercase tracking-wide";

    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Guardar Empleado';
    btnSubmit.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.remove('bg-amber-600', 'hover:bg-amber-700');

    document.getElementById('btnCancelar').classList.add('hidden');
}

async function eliminarEmpleado(id, btn) {
    if(!confirm('¿Estás seguro de eliminar este empleado?')) return;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try {
        const res = await fetch(`/api/empleados/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        if (res.ok) {
            cargarEmpleados(); // Recargar lista
        }
    } catch (error) { console.error(error); }
}
</script>
@endsection