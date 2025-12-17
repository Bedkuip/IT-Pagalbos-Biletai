@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Bilietai</h1>

        <a href="/tickets/create"
        id="create-ticket-btn"
        class="hidden bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Naujas bilietas
        </a>
    </div>

    <!-- Filtrai -->
    <div class="bg-white shadow-md rounded-xl p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">

            <div>
                <label class="text-sm text-gray-600">Statusas</label>
                <select id="filter-status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Visi</option>
                    <option value="open">Atidarytas</option>
                    <option value="in_progress">Vykdomas</option>
                    <option value="resolved">Išspręstas</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600">Specialistas</label>
                <input id="filter-specialist" type="text"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Pvz. Jonas">
            </div>

            <div>
                <label class="text-sm text-gray-600">Tipas</label>
                <input id="filter-type" type="text"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Pvz. printer">
            </div>

            <div>
                <label class="text-sm text-gray-600">Darbovietė</label>
                <select id="filter-workplace"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Visos</option>
                    @foreach($workplaces as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <button id="apply-filters"
                class="mt-4 bg-gray-800 hover:bg-black text-white px-4 py-2 rounded-lg transition">
            Taikyti filtrus
        </button>
    </div>

    <!-- Lentelė -->
    <div class="bg-white shadow-md rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm" id="tickets-table">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-2">ID</th>
                        <th class="py-2">Workplace</th>
                        <th class="py-2">Device</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Priority</th>
                        <th class="py-2">Sukurta</th>
                        <th class="py-2">Veiksmai</th>
                    </tr>
                </thead>
                <tbody id="tickets-body">
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
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

<!-- Modalas -->
<div id="ticket-modal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center">
    <div class="bg-white rounded-xl p-6 w-96 shadow-xl relative animate-[modalIn_0.25s_ease-out]">
        <button id="modal-close" class="absolute top-2 right-3 text-xl">&times;</button>
        <h2 class="text-lg font-semibold mb-3">Bilieto informacija</h2>
        <div id="modal-content" class="text-sm text-gray-700">
            Kraunama...
        </div>
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

// Load tickets
async function loadTickets(page = 1) {
    const status = document.getElementById('filter-status').value;
    const specialist = document.getElementById('filter-specialist').value;
    const type = document.getElementById('filter-type').value;
    const workplace = document.getElementById('filter-workplace').value;

    let url;

    // Jei pasirinkta darbovietė → naudoti tavo API metodą
    if (workplace) {
        url = `/api/v1/workplaces/${workplace}/tickets?page=${page}`;
    } else {
        url = `/api/v1/tickets?page=${page}`;
    }

    if (status) url += `&status=${status}`;
    if (specialist) url += `&assigned_specialist=${specialist}`;
    if (type) url += `&type=${type}`;

    const res = await apiFetch(url);
    const data = await res.json();

    const tbody = document.getElementById('tickets-body');
    tbody.innerHTML = '';

    data.data?.forEach(t => {
        tbody.innerHTML += `
            <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-2">${t.id}</td>
                <td class="py-2">${t.workplace_id}</td>
                <td class="py-2">${t.device_id}</td>
                <td class="py-2">${t.status}</td>
                <td class="py-2">${t.priority}</td>
                <td class="py-2">${t.created_at}</td>

                <td class="py-2 flex gap-3">

                    <!-- Peržiūrėti (visi gali) -->
                    <button onclick="viewTicket(${t.id})"
                            class="text-blue-600 hover:underline">Peržiūrėti</button>
                    <a href="/tickets/${t.id}/edit"
                    class="text-green-600 hover:underline">Redaguoti</a>

                    <button onclick="deleteTicket(${t.id})"
                            class="text-red-600 hover:underline">Trinti</button>
                </td>
            </tr>
        `;
    });

    // Pagination
    const pag = document.getElementById('pagination');
    pag.innerHTML = '';

    if (data.last_page) {
        for (let i = 1; i <= data.last_page; i++) {
            pag.innerHTML += `
                <button onclick="loadTickets(${i})"
                        class="px-3 py-1 rounded ${i === data.current_page ? 'bg-blue-600 text-white' : 'bg-gray-200'}">
                    ${i}
                </button>
            `;
        }
    }
}

// Modal
async function viewTicket(id) {
    const modal = document.getElementById('ticket-modal');
    const content = document.getElementById('modal-content');

    modal.classList.remove('hidden');
    content.innerHTML = 'Kraunama...';

    const res = await apiFetch(`/api/v1/tickets/${id}`);
    const t = await res.json();

    content.innerHTML = `
        <p><strong>ID:</strong> ${t.id}</p>
        <p><strong>Statusas:</strong> ${t.status}</p>
        <p><strong>Prioritetas:</strong> ${t.priority}</p>
        <p><strong>Aprašymas:</strong> ${t.description}</p>
        <p><strong>Specialistas:</strong> ${t.assigned_specialist ?? '-'}</p>
    `;
}

// Delete (tik admin)
async function deleteTicket(id) {
    if (!confirm("Ar tikrai norite ištrinti šį bilietą?")) return;

    const res = await apiFetch(`/api/v1/tickets/${id}`, {
        method: 'DELETE'
    });

    if (res.ok) {
        loadTickets();
    } else {
        alert("Nepavyko ištrinti bilieto.");
    }
}

document.getElementById('modal-close').onclick = () =>
    document.getElementById('ticket-modal').classList.add('hidden');

document.getElementById('apply-filters').onclick = () => loadTickets();

loadTickets();
</script>

<script>
const role = localStorage.getItem('user_role');

if (role === 'user' || role === 'admin') {
    document.getElementById('create-ticket-btn').classList.remove('hidden');
}
</script>


@endsection
