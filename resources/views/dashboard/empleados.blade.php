@extends('layout')

@section('title', 'Gestión de Empleados')
@section('breadcrumb', 'Lista de Empleados')

@section('content')
    <div class="space-y-6 text-left">
        
        {{-- Encabezado y Botón de Nuevo --}}
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Directorio</h2>
                <p class="text-slate-500 text-sm">Gestiona los empleados de la plataforma.</p>
            </div>
            <button onclick="abrirModalNuevo()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors flex items-center">
                <i class="fa-solid fa-plus mr-2"></i> Nuevo Empleado
            </button>
        </div>

        {{-- TABLA --}}
        <div class="overflow-hidden rounded-lg border border-slate-200 shadow-sm bg-white">
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
            
            {{-- CONTROLES DE PAGINACIÓN SIMPLIFICADOS --}}
            <div id="paginacionControles" class="bg-slate-50 px-4 py-3 flex items-center justify-between border-t border-slate-200 sm:px-6 hidden">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-slate-700">
                            Mostrando <span id="infoInicio" class="font-bold text-indigo-600"></span> a <span id="infoFin" class="font-bold text-indigo-600"></span> de <span id="infoTotal" class="font-bold text-indigo-600"></span>
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination" id="paginacionBotones">
                            {{-- JS genera solo 4 botones aquí --}}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL OVERLAY --}}
    <div id="modalEmpleado" class="fixed inset-0 bg-slate-900 bg-opacity-50 z-50 hidden flex items-center justify-center backdrop-blur-sm transition-opacity">
        
        {{-- CAJA DEL MODAL --}}
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl mx-4 overflow-hidden transform transition-all">
            
            {{-- HEADER DEL MODAL --}}
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                <h3 id="formTitle" class="text-sm font-bold text-indigo-600 uppercase tracking-wide">
                    <i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado
                </h3>
                <button type="button" onclick="cerrarModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- FORMULARIO --}}
            <form id="empleadoForm" class="p-6">
                <input type="hidden" id="editId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Nombre</label>
                        <input type="text" name="nombre" id="inputNombre" placeholder="Ej. Juan Pérez" 
                            required maxlength="50" pattern="^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$" 
                            title="Solo letras y espacios"
                            class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Email</label>
                        <input type="email" name="email" id="inputEmail" placeholder="juan@ejemplo.com" 
                            required maxlength="80"
                            class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Cargo</label>
                        <input type="text" name="cargo" id="inputCargo" placeholder="Ej. Desarrollador" 
                            required maxlength="50"
                            class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 transition">
                    </div>
                </div>

                {{-- FOOTER DEL MODAL (BOTONES) --}}
                <div class="flex justify-end gap-2 mt-8 pt-4 border-t border-slate-100">
                    {{-- Botón Eliminar (Solo se muestra al editar) --}}
                    <button type="button" id="btnModalEliminar" onclick="eliminarDesdeModal()"
                        class="hidden bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-4 rounded shadow-sm transition-colors mr-auto">
                        <i class="fa-solid fa-trash mr-1"></i> Borrar
                    </button>

                    <button type="button" onclick="cerrarModal()"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-2 px-4 rounded shadow-sm transition-colors">
                        Cancelar
                    </button>

                    <button type="submit" id="btnSubmit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded shadow transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-save mr-2"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
let editMode = false;
let todosLosEmpleados = []; 
let paginaActual = 1;
const empleadosPorPagina = 5; // REDUCIDO A 5

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
        
        const regexNombre = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]+$/;
        if (!regexNombre.test(dataObject.nombre) || dataObject.nombre.length > 50) {
            alert('El nombre es inválido. Recuerda: solo letras, espacios y máximo 50 caracteres.');
            btn.innerHTML = originalText;
            btn.disabled = false;
            return;
        }
        
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

            if (!res.ok) throw new Error('Error en la petición');

            await cargarEmpleados(); 
            cerrarModal(); // Cierra y limpia al guardar con éxito

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
        const data = await res.json();
        todosLosEmpleados = data.reverse(); 
        renderizarTabla();
    } catch (error) { console.error(error); }
}

function renderizarTabla() {
    const tbody = document.getElementById('empleadosBody');
    tbody.innerHTML = ''; 

    const indiceInicio = (paginaActual - 1) * empleadosPorPagina;
    const indiceFin = indiceInicio + empleadosPorPagina;
    const empleadosPagina = todosLosEmpleados.slice(indiceInicio, indiceFin);

    empleadosPagina.forEach(agregarFila);
    actualizarPaginacion();
}

function agregarFila(emp) {
    const tr = document.createElement('tr');
    tr.className = "hover:bg-slate-50 transition-colors cursor-pointer";
    
    const nombreEscapado = emp.nombre.replace(/'/g, "\\'");
    const emailEscapado = emp.email.replace(/'/g, "\\'");
    const cargoEscapado = emp.cargo.replace(/'/g, "\\'");

    // Ahora toda la fila es clickeable para abrir el modal de edición rápido
    tr.onclick = () => prepararEdicion(emp.id, nombreEscapado, emailEscapado, cargoEscapado);

    tr.innerHTML = `
        <td class="p-4 font-medium text-slate-900">${emp.nombre}</td>
        <td class="p-4">${emp.email}</td>
        <td class="p-4">
            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold">${emp.cargo}</span>
        </td>
        <td class="p-4 text-center">
            <button type="button" class="text-amber-500 hover:text-amber-700 hover:bg-amber-50 p-2 rounded-full transition" title="Editar">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
        </td>
    `;
    document.getElementById('empleadosBody').appendChild(tr); 
}

function actualizarPaginacion() {
    const totalEmpleados = todosLosEmpleados.length;
    const totalPaginas = Math.ceil(totalEmpleados / empleadosPorPagina);
    const contenedorPaginacion = document.getElementById('paginacionControles');
    const botonesContainer = document.getElementById('paginacionBotones');

    if (totalEmpleados <= empleadosPorPagina) {
        contenedorPaginacion.classList.add('hidden');
        return;
    }

    contenedorPaginacion.classList.remove('hidden');
    botonesContainer.innerHTML = '';

    const inicio = (paginaActual - 1) * empleadosPorPagina + 1;
    const fin = Math.min(paginaActual * empleadosPorPagina, totalEmpleados);
    document.getElementById('infoInicio').innerText = inicio;
    document.getElementById('infoFin').innerText = fin;
    document.getElementById('infoTotal').innerText = totalEmpleados;

    // SOLO 4 BOTONES DE NAVEGACIÓN
    const btnPrimero = crearBotonPaginacion('<i class="fa-solid fa-angles-left"></i>', 1, paginaActual === 1, 'primero');
    const btnAnterior = crearBotonPaginacion('<i class="fa-solid fa-chevron-left"></i>', paginaActual > 1 ? paginaActual - 1 : 1, paginaActual === 1, 'medio');
    const btnSiguiente = crearBotonPaginacion('<i class="fa-solid fa-chevron-right"></i>', paginaActual < totalPaginas ? paginaActual + 1 : totalPaginas, paginaActual === totalPaginas, 'medio');
    const btnUltimo = crearBotonPaginacion('<i class="fa-solid fa-angles-right"></i>', totalPaginas, paginaActual === totalPaginas, 'ultimo');

    botonesContainer.appendChild(btnPrimero);
    botonesContainer.appendChild(btnAnterior);
    botonesContainer.appendChild(btnSiguiente);
    botonesContainer.appendChild(btnUltimo);
}

function crearBotonPaginacion(texto, paginaDestino, deshabilitado = false, posicion = 'medio') {
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.innerHTML = texto;
    
    let clasesBase = "relative inline-flex items-center px-4 py-2 border text-sm font-medium transition-colors focus:outline-none ";
    
    if (deshabilitado) {
        clasesBase += "border-slate-300 text-slate-300 bg-slate-50 cursor-not-allowed ";
    } else {
        clasesBase += "bg-white border-slate-300 text-slate-500 hover:bg-slate-50 cursor-pointer ";
        btn.onclick = () => {
            paginaActual = paginaDestino;
            renderizarTabla();
        };
    }

    if (posicion === 'primero') clasesBase += "rounded-l-md ";
    if (posicion === 'ultimo') clasesBase += "rounded-r-md ";

    btn.className = clasesBase;
    return btn;
}

// === FUNCIONES DEL MODAL ===
function abrirModalNuevo() {
    resetearFormulario(); // Asegura que esté limpio
    document.getElementById('modalEmpleado').classList.remove('hidden');
}

function cerrarModal() {
    document.getElementById('modalEmpleado').classList.add('hidden');
    resetearFormulario();
}

function prepararEdicion(id, nombre, email, cargo) {
    editMode = true;
    document.getElementById('editId').value = id;
    document.getElementById('inputNombre').value = nombre;
    document.getElementById('inputEmail').value = email;
    document.getElementById('inputCargo').value = cargo;

    // Cambiar aspecto del modal a "Edición"
    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-pen-to-square mr-1"></i> Editando Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-amber-600 mb-4 uppercase tracking-wide";

    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-check mr-2"></i> Actualizar';
    btnSubmit.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.add('bg-amber-600', 'hover:bg-amber-700');

    // Mostrar el botón de Eliminar
    document.getElementById('btnModalEliminar').classList.remove('hidden');

    document.getElementById('modalEmpleado').classList.remove('hidden');
}

function resetearFormulario() {
    editMode = false;
    document.getElementById('empleadoForm').reset();
    document.getElementById('editId').value = '';

    // Restaurar aspecto a "Nuevo"
    document.getElementById('formTitle').innerHTML = '<i class="fa-solid fa-plus mr-1"></i> Nuevo Empleado';
    document.getElementById('formTitle').className = "text-sm font-bold text-indigo-600 mb-4 uppercase tracking-wide";

    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.innerHTML = '<i class="fa-solid fa-save mr-2"></i> Guardar';
    btnSubmit.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
    btnSubmit.classList.remove('bg-amber-600', 'hover:bg-amber-700');

    // Ocultar el botón de Eliminar
    document.getElementById('btnModalEliminar').classList.add('hidden');
}

async function eliminarDesdeModal() {
    const id = document.getElementById('editId').value;
    if(!confirm('¿Estás seguro de eliminar este empleado? Esta acción no se puede deshacer.')) return;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    try {
        const res = await fetch(`/api/empleados/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        });
        if (res.ok) {
            if (todosLosEmpleados.length % empleadosPorPagina === 1 && paginaActual > 1) {
                paginaActual--;
            }
            await cargarEmpleados(); 
            cerrarModal(); // Cierra el modal tras borrar exitosamente
        }
    } catch (error) { console.error(error); }
}
</script>
@endsection