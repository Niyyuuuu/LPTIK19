<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function piket(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', now()->year);

        $ticketsQuery = Tiket::query();
        if ($user->role === 'Piket') {
            $ticketsQuery->where('user_id', $user->id);
        }

        $tickets = $ticketsQuery->whereYear('created_at', $year)->get();

        $counts = [
            'status' => [
                'diproses' => $tickets->where('status', 'Diproses')->count(),
                'selesai' => $tickets->where('status', 'Selesai')->count(),
                'ditutup' => $tickets->where('status', 'Ditutup')->count(),
            ],
            'prioritas' => [
                'tinggi' => $tickets->where('prioritas', 'Tinggi')->count(),
                'sedang' => $tickets->where('prioritas', 'Sedang')->count(),
                'rendah' => $tickets->where('prioritas', 'Rendah')->count(),
            ],
            'area' => [
                'Kemhan' => $tickets->where('area', 'Kemhan')->count(),
                'Luar Kemhan' => $tickets->where('area', 'Luar Kemhan')->count(),
            ]
        ];

        $totalTickets = $tickets->count();

        return view('piket', compact('tickets', 'counts', 'year', 'totalTickets'));
    }

    public function tickets()
    {
        $tiket = Tiket::with('user')->get();
        return view('piket.tickets', compact('tiket'));
    }

    public function processTicket($id)
        {
            $ticket = Tiket::findOrFail($id);
            $technicians = User::where('role', 'Technician')->get();

            return view('piket.process-ticket', compact('ticket', 'technicians'));

        }

        public function assignTechnician(Request $request, $id)
        {
            $request->validate([
                'technician_id' => 'required|exists:users,id',
            ]);

            $ticket = Tiket::findOrFail($id);
            $ticket->technician_id = $request->input('technician_id');
            $ticket->status = 'Diproses'; // Update status ticket
            $ticket->save();

            return redirect()->route('tickets')->with('success', 'Technician assigned successfully!');
        }
}
