@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    cargarEmpleados();

    const form = document.getElementById('empleadoForm');
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    form.addEventListener('submit', async e => {
        e.preventDefault();

        const formData = new FormData(form);

        const res = await fetch('/api/empleados', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
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
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td class="p-2">${emp.nombre}</td>
        <td>${emp.email}</td>
        <td>${emp.cargo}</td>
        <td>
            <button class="text-red-600" onclick="eliminarEmpleado(${emp.id}, this)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    `;
    document.getElementById('empleadosBody').prepend(tr);
}

async function eliminarEmpleado(id, btn) {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute('content');

    await fetch(`/api/empleados/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    });

    btn.closest('tr').remove();
}
</script>
@endsection
