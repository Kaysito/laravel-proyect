@extends('layouts.app')

@section('title', 'Gestión de Empleados')

@section('breadcrumb', 'Lista de Empleados')

@section('content')
    <div class="space-y-6 text-left">
        
        {{-- Encabezado --}}
        <div class="border-b border-slate-200 pb-4">
            <h2 class="text-2xl font-bold text-slate-800">Directorio</h2>
            <p class="text-slate-500 text-sm">Gestiona los empleados de la plataforma.</p>
        </div>

        {{-- 1. FORMULARIO (ID: empleadoForm) --}}
        <form id="empleadoForm" class="bg-slate-50 p-6 rounded-lg border border-slate-200 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                
                {{-- Input Nombre --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Nombre</label>
                    <input type="text" name="nombre" placeholder="Ej. Juan Pérez" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                {{-- Input Email --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Email</label>
                    <input type="email" name="email" placeholder="juan@ejemplo.com" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                {{-- Input Cargo --}}
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1 uppercase">Cargo</label>
                    <input type="text" name="cargo" placeholder="Ej. Desarrollador" required
                        class="w-full p-2 border border-slate-300 rounded focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded shadow transition-colors flex items-center justify-center ml-auto">
                    <i class="fa-solid fa-save mr-2"></i> Guardar Empleado
                </button>
            </div>
        </form>

        {{-- 2. TABLA (Cuerpo ID: empleadosBody) --}}
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
                    {{-- Aquí tu JS insertará las filas automáticamente --}}
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Cargar empleados al iniciar
    cargarEmpleados();

    const form = document.getElementById('empleadoForm');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Manejar envío del formulario
    form.addEventListener('submit', async e => {
        e.preventDefault();

        // Feedback visual simple (opcional)
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Guardando...';
        btn.disabled = true;

        try {
            const formData = new FormData(form);

            const res = await fetch('/api/empleados', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!res.ok) throw new Error('Error al guardar');

            const data = await res.json();
            
            // Agregar la nueva fila arriba
            agregarFila(data.empleado); 
            
            // Limpiar formulario
            form.reset();

        } catch (error) {
            console.error(error);
            alert('Hubo un error al guardar el empleado.');
        } finally {
            // Restaurar botón
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
});

async function cargarEmpleados() {
    try {
        const res = await fetch('/api/empleados');
        const empleados = await res.json();
        // Limpiamos antes por si acaso se llama doble
        document.getElementById('empleadosBody').innerHTML = ''; 
        empleados.forEach(agregarFila);
    } catch (error) {
        console.error('Error cargando empleados:', error);
    }
}

function agregarFila(emp) {
    const tr = document.createElement('tr');
    tr.className = "hover:bg-slate-50 transition-colors"; // Clase para efecto hover
    tr.innerHTML = `
        <td class="p-4 font-medium text-slate-900">${emp.nombre}</td>
        <td class="p-4">${emp.email}</td>
        <td class="p-4">
            <span class="bg-indigo-100 text-indigo-700 py-1 px-3 rounded-full text-xs font-bold">
                ${emp.cargo}
            </span>
        </td>
        <td class="p-4 text-center">
            <button class="text-red-500 hover:text-red-700 hover:bg-red-50 p-2 rounded-full transition" 
                    title="Eliminar"
                    onclick="eliminarEmpleado(${emp.id}, this)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;
    // Prepend para que el más nuevo salga arriba
    document.getElementById('empleadosBody').prepend(tr);
}

async function eliminarEmpleado(id, btn) {
    if(!confirm('¿Estás seguro de eliminar este empleado?')) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    try {
        const res = await fetch(`/api/empleados/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        if (res.ok) {
            // Animación simple para eliminar
            const row = btn.closest('tr');
            row.style.opacity = '0';
            setTimeout(() => row.remove(), 300);
        } else {
            alert('No se pudo eliminar el registro.');
        }
    } catch (error) {
        console.error(error);
    }
}
</script>
@endsection