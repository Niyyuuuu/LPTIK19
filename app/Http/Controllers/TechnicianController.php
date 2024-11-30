<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Tiket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', date('Y'));
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Define attributes to count
        $attributes = [
            'status_id' => [1, 2, 3],
            'prioritas' => ['tinggi', 'sedang', 'rendah'],
            'permasalahan' => ['jaringan', 'software', 'hardware'],
            'rating' => [1, 2, 3, 4, 5],
            'area' => ['Kemhan', 'Luar Kemhan'],
        ];
    
        // Initialize counts
        $counts = [];
    
        // Base query with year filter
        $query = Tiket::query()->whereYear('created_at', $selectedYear);
    
        // Apply date range filter if both dates are provided
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        // Count tickets based on defined attributes and filters
        foreach ($attributes as $key => $values) {
            foreach ($values as $value) {
                $counts[$key][$value] = (clone $query)->where($key, $value)->count();
            }
        }
    
        // Get total users
        $total_users = User::count();
    
        // Get total tickets with filters applied
        $total_tiket = $query->count();
    
        // Pass data to the view
        return view('technisi', compact(
            'counts',
            'total_users',
            'total_tiket',
            'selectedYear'
        ));
    }
    


    public function task()
    {
        $tickets = Tiket::where('technician_id', Auth::id())
            ->where('status_id', 2) // Hanya tiket yang diproses
            ->get();

        // Periksa tiket yang memiliki status 'Proses Selesai' (status_id = 4) yang lebih dari 2 hari
        $ticketsToClose = Tiket::where('status_id', 4)
            ->where('updated_at', '<=', Carbon::now()->subDays(2))
            ->get();

        // Ubah status tiket yang sudah lebih dari 2 hari menjadi 'Selesai' (status_id = 3)
        foreach ($ticketsToClose as $ticket) {
            $ticket->status_id = 3;  // Set status menjadi 'Selesai'
            $ticket->save();
        }

        return view('technisian.tasks', compact('tickets'));
    }


    public function ticketList()
    {
        $tickets = Tiket::with('user')->get();
        return view('technisian.ticket-list', compact('tickets'));
    }
    public function tutupTiket($id)
    {
        $ticket = Tiket::findOrFail($id);  // Ambil tiket berdasarkan ID
        $ticket->status_id = 4;            // Set status menjadi 4 (ditutup)
        $ticket->save();                   // Simpan perubahan

        // Redirect kembali ke halaman tasks dengan pesan sukses
        return redirect()->route('tasks')->with('success', 'Tiket berhasil ditutup.');
    }


}
