@extends('layouts.app')

@section('title', 'Empleados')

@section('content')
<h1 class="text-2xl font-bold mb-6">👥 Empleados</h1>

<form id="empleadoForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    @csrf
    <input class="border p-2 rounded" name="nombre" placeholder="Nombre">
    <input class="border p-2 rounded" name="email" placeholder="Email">
    <input class="border p-2 rounded" name="cargo" placeholder="Cargo">
    <button class="bg-indigo-600 text-white rounded py-2 md:col-span-3">
        Agregar empleado
    </button>
</form>

<table class="w-full border text-sm">
    <thead class="bg-slate-100">
        <tr>
            <th class="p-2">Nombre</th>
            <th>Email</th>
            <th>Cargo</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="empleadosBody"></tbody>
</table>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    cargarEmpleados();

    const form = document.getElementById('empleadoForm');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        const res = await fetch('/api/empleados', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: formData
        });

        const data = await res.json();
        agregarFila(data.empleado);
        form.reset();
    });
});

async function cargarEmpleados() {
    const res = await fetch('/api/empleados');
    const empleados = await res.json();

    empleados.forEach(agregarFila);
}

function agregarFila(emp) {
    const tbody = document.getElementById('empleadosBody');

    const tr = document.createElement('tr');

    const tdNombre = document.createElement('td');
    tdNombre.className = 'p-2';
    tdNombre.textContent = emp.nombre;

    const tdEmail = document.createElement('td');
    tdEmail.textContent = emp.email;

    const tdCargo = document.createElement('td');
    tdCargo.textContent = emp.cargo;

    const tdAcciones = document.createElement('td');

    const btnEliminar = document.createElement('button');
    btnEliminar.className = 'text-red-600';
    btnEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>';

    btnEliminar.addEventListener('click', async () => {
        await eliminarEmpleado(emp.id);
        tr.remove(); // DOM PURO
    });

    tdAcciones.appendChild(btnEliminar);

    tr.appendChild(tdNombre);
    tr.appendChild(tdEmail);
    tr.appendChild(tdCargo);
    tr.appendChild(tdAcciones);

    tbody.prepend(tr);
}

async function eliminarEmpleado(id) {
    await fetch(`/api/empleados/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
        }
    });
}
</script>
@endsection
