@extends('layout')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-semibold mb-6">Naujas bilietas</h1>

    <div class="bg-white shadow-md rounded-xl p-6">
        <form id="create-ticket-form" class="space-y-5">

            <div>
                <label class="block text-sm text-gray-600 mb-1">Darbovietė</label>
                <select id="workplace_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Įrenginys</label>
                <select id="device_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Statusas</label>
                <select id="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="open">Atidarytas</option>
                    <option value="in_progress">Vykdomas</option>
                    <option value="resolved">Išspręstas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Prioritetas</label>
                <select id="priority"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="low">Žemas</option>
                    <option value="medium">Vidutinis</option>
                    <option value="high">Aukštas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Specialistas (nebūtina)</label>
                <input id="assigned_specialist" type="text"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Pvz. Jonas">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Aprašymas</label>
                <textarea id="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2"
                          placeholder="Aprašykite problemą..."></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                Sukurti bilietą
            </button>

        </form>
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

// Load workplaces and devices
async function loadSelects() {
    const w = await apiFetch('/api/v1/workplaces');
    const workplaces = await w.json();

    const d = await apiFetch('/api/v1/devices');
    const devices = await d.json();

    const wSelect = document.getElementById('workplace_id');
    const dSelect = document.getElementById('device_id');

    workplaces.forEach(w => {
        wSelect.innerHTML += `<option value="${w.id}">${w.name}</option>`;
    });

    devices.forEach(d => {
        dSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
    });
}

loadSelects();

// Submit form
document.getElementById('create-ticket-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const payload = {
        workplace_id: document.getElementById('workplace_id').value,
        device_id: document.getElementById('device_id').value,
        status: document.getElementById('status').value,
        priority: document.getElementById('priority').value,
        description: document.getElementById('description').value,
        assigned_specialist: document.getElementById('assigned_specialist').value || null
    };

    const res = await apiFetch('/api/v1/tickets', {
        method: 'POST',
        body: JSON.stringify(payload)
    });

    if (res.ok) {
        window.location.href = '/tickets';
    } else {
        alert('Klaida kuriant bilietą');
    }
});
</script>

@endsection
