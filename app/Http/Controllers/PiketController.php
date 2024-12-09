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

    $statusLabels = [
        1 => 'Menunggu',
        2 => 'Diproses',
        3 => 'Selesai',
        4 => 'Proses Selesai'
    ];

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
            1 => $tickets->where('status_id', 1)->count() ?? 0,
            2 => $tickets->where('status_id', 2)->count() ?? 0,
            3 => $tickets->where('status_id', 3)->count() ?? 0,
            4 => $tickets->where('status_id', 4)->count() ?? 0,
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

    return view('piket', compact('tickets', 'counts', 'year', 'totalTickets', 'statusLabels'));
}



    public function tickets()
    {
        // Ambil tiket dengan status "Menunggu" untuk tabel pertama
        $filteredTickets = Tiket::with('user', 'satkerData')->whereIn('status_id', [1, 2, 4])->orderBy('created_at', 'desc')->get();

        // Ambil semua tiket untuk tabel kedua
        $allTickets = Tiket::with('user', 'satkerData')->orderBy('created_at', 'desc')->get();


        // Kirim kedua dataset ke view
        return view('piket.tickets', compact('filteredTickets', 'allTickets'));
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
        
            // Update tiket dengan teknisi yang ditugaskan
            $ticket = Tiket::findOrFail($id);
            $ticket->technician_id = $request->input('technician_id');
            $ticket->status_id = 2; // Ubah status menjadi 'diproses'
            $ticket->save();
        
            // Ambil data teknisi untuk notifikasi
            $technician = User::findOrFail($ticket->technician_id);
        
            // Token bot Telegram dan chat ID tujuan
            $token = '7633250290:AAGVwFBqmNeQiHCl3K13hsoIBJsRnt38YXo'; // Ganti dengan token bot Telegram Anda
            $chat_id = '1164538381'; // Ganti dengan chat ID tujuan Anda
        
            // Format pesan notifikasi
            $createdAt = \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y, H:i');
            $ticketNumber = str_pad($ticket->id, 6, '0', STR_PAD_LEFT);
            $cleanSubjek = strip_tags($ticket->subjek);
        
            $pesan = "👨‍🔧 *Teknisi Ditugaskan*\n\n";
            $pesan .= "*No. Tiket:* {$ticketNumber}\n";
            $pesan .= "🔖 *Subjek:* {$cleanSubjek}\n";
            $pesan .= "🛠️ *Teknisi:* {$technician->name}\n";
            $pesan .= "📅 *Tanggal Penugasan:* {$createdAt}\n";
            $pesan .= "⏳ *Status:* Diproses\n";
        
            // Mengirim permintaan ke API Telegram
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $url .= "?chat_id={$chat_id}&text=" . urlencode($pesan) . "&parse_mode=Markdown";
        
            file_get_contents($url);
        
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
