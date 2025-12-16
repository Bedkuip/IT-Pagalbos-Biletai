@extends('layout')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Įrenginių sąrašas</h1>

    <div class="bg-white shadow-md rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="devices-table">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-2">ID</th>
                        <th class="py-2">Pavadinimas</th>
                        <th class="py-2">Tipas</th>
                        <th class="py-2">Statusas</th>
                        <th class="py-2">Specialistas</th>
                    </tr>
                </thead>
                <tbody id="devices-body">
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            Kraunama...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Paginacija -->
        <div id="pagination" class="flex justify-center mt-4 gap-2"></div>
    </div>

</div>

<script>
// Global fetch helper
async function apiFetch(url, options = {}) {
    const token = localStorage.getItem('access_token');
    options.headers = {
        ...(options.headers || {}),
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/json'
    };
    return fetch(url, options);
}

// Load devices
async function loadDevices(page = 1) {
    const res = await apiFetch(`/api/v1/devices?page=${page}`);
    const data = await res.json();

    const tbody = document.getElementById('devices-body');
    tbody.innerHTML = '';

    data.data.forEach(d => {
        tbody.innerHTML += `
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-2">${d.id}</td>
                <td class="py-2">${d.name}</td>
                <td class="py-2">${d.type}</td>
                <td class="py-2">${d.status}</td>
                <td class="py-2">${d.assigned_specialist ?? '-'}</td>
            </tr>
        `;
    });

    // Pagination
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';

    for (let i = 1; i <= data.last_page; i++) {
        pag.innerHTML += `
            <button onclick="loadDevices(${i})"
                    class="px-3 py-1 rounded ${i === data.current_page ? 'bg-blue-600 text-white' : 'bg-gray-200'}">
                ${i}
            </button>
        `;
    }
}

loadDevices();
</script>

@endsection
