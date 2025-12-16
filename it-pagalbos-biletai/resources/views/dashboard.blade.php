@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Puslapio antraštė -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Pagrindinis skydelis</h1>
        <p class="text-gray-500 text-sm">Sveiki sugrįžę, {{ auth()->user()->name ?? 'Vartotojau' }}.</p>
    </div>

    <!-- Statistinės kortelės -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white shadow-md rounded-xl p-5 flex items-center gap-4">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Viso bilietų</p>
                <p class="text-xl font-semibold">{{ $stats['total'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl p-5 flex items-center gap-4">
            <div class="p-3 bg-yellow-100 text-yellow-600 rounded-lg">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Laukia</p>
                <p class="text-xl font-semibold">{{ $stats['pending'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl p-5 flex items-center gap-4">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Išspręsti</p>
                <p class="text-xl font-semibold">{{ $stats['resolved'] ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-xl p-5 flex items-center gap-4">
            <div class="p-3 bg-red-100 text-red-600 rounded-lg">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Aukšto prioriteto</p>
                <p class="text-xl font-semibold">{{ $stats['high_priority'] ?? 0 }}</p>
            </div>
        </div>

    </div>

    <!-- Paskutiniai bilietai -->
    <div class="bg-white shadow-md rounded-xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Paskutiniai bilietai</h2>
            <a href="/tickets/create"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm shadow transition flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Naujas bilietas
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b text-gray-600">
                        <th class="py-2">Pavadinimas</th>
                        <th class="py-2">Įrenginys</th>
                        <th class="py-2">Būsena</th>
                        <th class="py-2">Sukurta</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets ?? [] as $ticket)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2">{{ $ticket->title }}</td>
                            <td class="py-2">{{ $ticket->device->name ?? '-' }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded text-white text-xs
                                    @if($ticket->status === 'pending') bg-yellow-500
                                    @elseif($ticket->status === 'resolved') bg-green-600
                                    @else bg-gray-500 @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="py-2">{{ $ticket->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-500">
                                Nėra bilietų.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Logout mygtukas -->
    <div class="mt-8">
        <button id="logout-btn"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow transition">
            <i class="fa-solid fa-right-from-bracket mr-1"></i> Atsijungti
        </button>
    </div>

</div>

<script>
    document.getElementById('logout-btn').addEventListener('click', async function() {
        const refresh = localStorage.getItem('refresh_token');

        await fetch('/auth/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ refresh_token: refresh })
        });

        localStorage.clear();
        window.location.href = '/';
    });
</script>
@endsection
