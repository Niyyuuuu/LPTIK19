<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use App\Models\User;
use App\Models\Permasalahan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $attributes = [
            'status_id' => [1, 2, 3, 4],
            'prioritas' => ['tinggi', 'sedang', 'rendah'],
            'permasalahan_id' => Permasalahan::all()->pluck('id')->toArray(),
            'rating' => [1, 2, 3, 4, 5],
            'area' => ['Kemhan', 'Luar Kemhan'],
        ];
    
        $statusLabels = [
            1 => 'Menunggu',
            2 => 'Diproses',
            3 => 'Selesai',
            4 => 'Proses Selesai',
        ];
    
        $counts = [];
    
        $query = Tiket::query()->whereYear('created_at', $selectedYear);
    
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        foreach ($attributes as $key => $values) {
            foreach ($values as $value) {
                if ($key == 'status_id') {
                    $statusText = $statusLabels[$value] ?? 'Unknown';
                    $counts[$key][$value] = (clone $query)->where($key, $value)->count();
                } else {
                    $counts[$key][$value] = (clone $query)->where($key, $value)->count();
                }
            }
        }
    
        // Get total users
        $total_users = User::count();
        $total_tiket = $query->count();
    
        // Pass data to the view
        return view('technisi', compact(
            'counts',
            'total_users',
            'total_tiket',
            'selectedYear',
            'statusLabels'
        ));
    }

    public function task()
    {
        $tickets = Tiket::where('technician_id', Auth::id())
            ->where('status_id', 2)
            ->orderBy('created_at', 'desc')
            ->get();

        $ticketsToClose = Tiket::where('status_id', 4)
            ->where('updated_at', '<=', Carbon::now()->subDays(2))
            ->get();

        foreach ($ticketsToClose as $ticket) {
            $ticket->status_id = 3;
            $ticket->save();
        }

        return view('technisian.tasks', compact('tickets'));
    }


    public function ticketList()
    {
        $tickets = Tiket::with('user')->orderBy('created_at','desc')->get();
        return view('technisian.ticket-list', compact('tickets'));
    }
    public function tutupTiket($id)
    {
        $ticket = Tiket::findOrFail($id);
        $ticket->status_id = 4;
        $ticket->technician_id = Auth::id();
        $ticket->save();

        // Token bot Telegram dan chat ID tujuan
        $token = '7633250290:AAGVwFBqmNeQiHCl3K13hsoIBJsRnt38YXo'; // Ganti dengan token bot Telegram Anda
        $chat_id = '1164538381'; // Ganti dengan chat ID tujuan Anda

        // Ambil nama teknisi
        $technicianName = Auth::user()->name;

        // Format pesan notifikasi
        $createdAt = \Carbon\Carbon::parse($ticket->updated_at)->format('d M Y, H:i');
        $ticketNumber = str_pad($ticket->id, 6, '0', STR_PAD_LEFT);
        $cleanSubjek = strip_tags($ticket->subjek);
        $cleanPesan = strip_tags($ticket->pesan);

        $pesan = "📢 *Pengaduan Proses Selesai*\n\n";
        $pesan .= "*No. Tiket:* {$ticketNumber}\n";
        $pesan .= "🔖 *Subjek:* {$cleanSubjek}\n";
        $pesan .= "📝 *Pesan:* {$cleanPesan}\n\n";
        $pesan .= "👤 *Teknisi:* {$technicianName}\n";
        $pesan .= "📅 *Tanggal Pembaruan:* {$createdAt}\n";
        $pesan .= "⏳ *Status:* Proses Selesai\n";

        // Mengirim permintaan ke API Telegram
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $url .= "?chat_id={$chat_id}&text=" . urlencode($pesan) . "&parse_mode=Markdown";

        file_get_contents($url);

        return redirect()->route('tasks')->with('success', 'Tiket berhasil ditutup.');
    }

}
