<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Satker;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TiketController extends Controller
{
    /**
     * Mendapatkan aturan validasi yang digunakan untuk membuat dan memperbarui tiket.
     *
     * @return array
     */
    private function validationRules()
    {
        return [
            "subjek" => 'required|string|max:255',
            "permasalahan" => 'required|string|max:255',
            "satker" => 'required|exists:table_satker,id',
            "prioritas" => 'required|string|max:255',
            "area" => 'required|string|max:255',
            "pesan" => 'required|string|max:5000',
            "lampiran" => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ];
    }

    public function show($id)
    { 
        $tiket = Tiket::with('satkerData')->findOrFail($id);
        return view('detail-tiket', compact('tiket'));
    }

    public function create()
    {
        $satkers = Satker::all();
        return view('buat-pengaduan', compact('satkers'));
    }

    public function daftar_pengaduan()
    {
        $tiket = Tiket::where('created_by', Auth::id())->get();
        return view('daftar-pengaduan', compact('tiket'));
    }

    public function history_pengaduan()
    {
        $tiket = Tiket::where('created_by', Auth::id())
                      ->whereIn('status', ['Selesai'])
                      ->get();
        return view('history-pengaduan', compact('tiket'));
    }

    public function buat_pengaduan(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['tanggal'] = today();
        $data['created_by'] = Auth::id();

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        Tiket::create($data);

        return $this->redirectBasedOnRole()->with('success', 'Pengaduan anda sedang diproses. Terima kasih');
    }

    public function tutup($id)
    {
        Tiket::where('id', $id)->update(['status' => 'Selesai']);
        return $this->redirectBasedOnRole()->with('success', 'Tiket berhasil ditutup');
    }

    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);
        $satkers = Satker::all();
        return view('edit-pengaduan', compact('tiket', 'satkers'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tiket = Tiket::findOrFail($id);
        $data = $validator->validated();

        if ($request->hasFile('lampiran')) {
            if ($tiket->lampiran) {
                Storage::delete('public/' . $tiket->lampiran);
            }
            $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        $tiket->update($data);

        return $this->redirectBasedOnRole()->with('success', 'Tiket berhasil diperbarui');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'Admin':
                return redirect()->route('admin');
            case 'Technisian':
                return redirect()->route('technician');
            case 'Piket':
                return redirect()->route('piket');
            case 'User':
            default:
                return redirect()->route('daftar-pengaduan');
        }
    }



    public function showRatingForm($id)
    {
        $tiket = Tiket::findOrFail($id);

        if (!in_array($tiket->status, ['Selesai'])) {
            return redirect()->back()->with('error', 'Rating hanya dapat diberikan untuk tiket yang selesai.');
        }

        if (!is_null($tiket->rating)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk tiket ini.');
        }

        return view('rating', compact('tiket'));
    }

    public function submitRating(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'rating_comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tiket = Tiket::findOrFail($id);

        if ($tiket->created_by !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memberikan rating pada tiket ini.');
        }

        if (!in_array($tiket->status, ['Selesai'])) {
            return redirect()->back()->with('error', 'Rating hanya dapat diberikan untuk tiket yang selesai.');
        }

        if (!is_null($tiket->rating)) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk tiket ini.');
        }

        $tiket->update([
            'rating' => $request->input('rating'),
            'rating_comment' => $request->input('rating_comment'),
        ]);

        return redirect()->back()->with('success', 'Rating berhasil diberikan. Terima kasih!');
    }

    public function dashboard(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $userId = Auth::id();

        // Ubah status menjadi sesuai dengan yang ada di database (misalnya, dengan huruf kapital)
        $statuses = ['Selesai', 'Diproses'];
        $statusLabels = [
            'Diproses' => 'Pengaduan Diproses',
            'Selesai' => 'Pengaduan Selesai'
        ];

        // Mengambil data pengaduan per bulan berdasarkan status
        $pengaduanData = Tiket::selectRaw('MONTH(created_at) as month, status, COUNT(*) as count')
            ->whereYear('created_at', $tahun)
            ->where('created_by', $userId)
            ->whereIn('status', $statuses)
            ->groupBy('month', 'status')
            ->get()
            ->groupBy('status')
            ->mapWithKeys(function ($items, $status) {
                return [$status => $items->pluck('count', 'month')->all()];
            });

        $totalPengaduanPerMonth = Tiket::whereYear('created_at', $tahun)
            ->where('created_by', $userId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->all();

        $months = range(1, 12);
        $monthNames = collect($months)->map(fn($m) => \Carbon\Carbon::create()->month($m)->format('F'))->toArray();

        // Menyiapkan data untuk setiap status
        $dataPerStatus = [];
        foreach ($statuses as $status) {
            $dataPerStatus[] = [
                'name' => $statusLabels[$status],
                'data' => array_map(fn($m) => $pengaduanData[$status][$m] ?? 0, $months),
                'color' => match($status) {
                    'Selesai' => '#4BC0C0',
                    'Diproses' => '#9966FF',
                    default => '#FF6384',
                },
            ];
        }

        // Menyiapkan kartu statistik
        $cardData = [
            'Total Pengaduan' => array_sum($totalPengaduanPerMonth),
            'Pengaduan Diproses' => array_sum($pengaduanData['Diproses'] ?? []),
            'Pengaduan Selesai' => array_sum($pengaduanData['Selesai'] ?? []),
        ];

        $years = Tiket::where('created_by', $userId)
            ->selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard-pengaduan', compact(
            'cardData',
            'dataPerStatus',
            'tahun',
            'years',
            'monthNames'
        ));
    }









    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'tiket_id' => 'required|exists:tiket,id',
            'content' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $chatMessage = new ChatMessage();
        $chatMessage->tiket_id = $validated['tiket_id'];
        $chatMessage->user_id = Auth::user()->id;
        $chatMessage->content = $validated['content'];

        if ($request->hasFile('lampiran')) {
            $chatMessage['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        $chatMessage->save();

        return response()->json(['success' => true]);
    }


    public function getChatMessages($id)
    {
        $messages = ChatMessage::where('tiket_id', $id)
            ->with('user:id,name')
            ->get()
            ->map(function ($message) {
                return [
                    'content' => $message->content,
                    'user_id' => $message->user_id,
                    'user_name' => $message->user->name,
                    'created_at' => $message->created_at->format('H:i'),
                    'lampiran' => $message->lampiran ? asset('storage/' . str_replace('public/', '', $message->lampiran)) : null,
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function cardTickets($category, $value)
    {
        if (in_array($category, ['status', 'prioritas', 'area'])) {
            $tickets = Tiket::where($category, strtolower($value))->get();
        } else {
            $tickets = collect(); // Collection kosong jika kategori tidak sesuai
        }
    
        // Tampilkan tampilan dengan data tiket yang diambil
        return view('card-tickets', compact('tickets', 'category', 'value'));
    }
    

}
