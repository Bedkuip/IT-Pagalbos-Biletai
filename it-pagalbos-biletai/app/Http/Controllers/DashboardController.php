<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistika
        $stats = [
            'total' => Ticket::count(),
            'pending' => Ticket::where('status', 'open')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'high_priority' => Ticket::where('priority', 'high')->count(),
        ];

        // Paskutiniai 5 bilietai
        $recentTickets = Ticket::with('device')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTickets'));
    }
}
