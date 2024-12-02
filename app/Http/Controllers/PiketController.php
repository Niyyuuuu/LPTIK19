<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use App\Models\User;
use App\Models\Satker;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function piket(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', now()->year);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $ticketsQuery = Tiket::query();

        if ($user->role === 'Piket') {
            $ticketsQuery->with('user');
        }

        if (!$startDate && !$endDate) {
            $ticketsQuery->whereYear('created_at', $year);
        }

        if ($startDate) {
            $ticketsQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $ticketsQuery->whereDate('created_at', '<=', $endDate);
        }

        $tickets = $ticketsQuery->get();

        $counts = [
            'status_id' => [
                "Menunggu" => $tickets->where('status_id', 1)->count() ?? 0,
                "Diproses" => $tickets->where('status_id', 2)->count() ?? 0,
                "Proses Selesai" => $tickets->where('status_id', 4)->count() ?? 0,
                "Selesai" => $tickets->where('status_id', 3)->count() ?? 0,
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
        $tiket = Tiket::with('user')->where('status_id', 1)->get();
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
            $ticket->status_id = 2;
            $ticket->save();

            return redirect()->route('tickets')->with('success', 'Technician assigned successfully!');
        }

        public function edit($id)
        {
            $ticket = Tiket::findOrFail($id);
            $prioritas = ['Tinggi', 'Sedang', 'Rendah']; // Sesuaikan dengan pilihan yang diinginkan
            return view('piket.edit-tickets', compact('ticket', 'prioritas'));
        }

        public function update(Request $request, $id)
        {
            $request->validate([
                'prioritas' => 'required|in:Tinggi,Sedang,Rendah',
            ]);

            $ticket = Tiket::findOrFail($id);
            $ticket->prioritas = $request->input('prioritas');
            $ticket->save();

            return redirect()->route('tickets')->with('success', 'Prioritas berhasil diperbarui!');
        }

        public function feedback()
        {
            $ratingticket = Tiket::whereNotNull('rating')->get();
            return view('piket.feedback', compact('ratingticket'));
        }
}
