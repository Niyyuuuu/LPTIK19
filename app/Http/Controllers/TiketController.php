<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
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
        $tiket = Tiket::with('statusData')->findOrFail($id);
        $tiket = Tiket::with('technician')->findOrFail($id);
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
                      ->where('status_id', 3)
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
    $data['status_id'] = 1;

    if ($request->hasFile('lampiran')) {
        $data['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
    }

    $tiket = Tiket::create($data);

    // Kirim notifikasi ke Telegram
    $token = '7633250290:AAGVwFBqmNeQiHCl3K13hsoIBJsRnt38YXo'; // Ganti dengan token bot Telegram Anda
    $chat_id = '1164538381'; // Ganti dengan chat ID tujuan Anda

    // Format pesan notifikasi
    $createdAt = !empty($data['created_at']) ? \Carbon\Carbon::parse($data['created_at'])->format('d M Y, H:i') : now()->format('d M Y, H:i');

    $ticketNumber = str_pad($tiket->id, 6, '0', STR_PAD_LEFT);
    $cleanSubjek = strip_tags($data['subjek']);
    $cleanPesan = strip_tags($data['pesan']);

    $pesan = "📢 *Pengaduan Baru Diterima*\n\n";
    $pesan .= "*No. Tiket:* {$ticketNumber}\n";
    $pesan .= "🔖 *Subjek:* {$cleanSubjek}\n";
    $pesan .= "📝 *Pesan:* {$cleanPesan}\n\n";
    $pesan .= "📅 *Tanggal Pengaduan:* {$createdAt}\n";
    $pesan .= "⏳ *Status:* Belum Diproses\n";

    // Mengirim permintaan ke API Telegram
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $url .= "?chat_id={$chat_id}&text=" . urlencode($pesan) . "&parse_mode=Markdown";

    file_get_contents($url);



        return redirect('daftar-pengaduan')->with('success', 'Tiket berhasil dibuat');
    }   


    public function tutup($id)
    {
        Tiket::where('id', $id)->update(['status_id' => 3]);
        return $this->redirectBasedOnRole();
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
                return redirect()->route('daftar-pengaduan');
        }
    }



    public function showRatingForm($id)
    {
        $tiket = Tiket::findOrFail($id);

        if (!in_array($tiket->status_id, [3])) {
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
            return redirect()->back()->with('error');
        }

        if (!in_array($tiket->status_id, [3])) {
            return redirect()->back()->with('error');
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
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $userId = Auth::id();

    $statuses = [1, 2, 3, 4];
    $statusLabels = [
        1 => 'Pengaduan Menunggu',
        2 => 'Pengaduan Diproses',
        3 => 'Pengaduan Selesai',
        4 => 'Pengaduan Proses Selesai'
    ];

    $pengaduanQuery = Tiket::selectRaw('MONTH(created_at) as month, status_id, COUNT(*) as count')
        ->where('created_by', $userId)
        ->whereIn('status_id', $statuses);

    if ($startDate && $endDate) {
        $pengaduanQuery->whereBetween('created_at', [$startDate, $endDate]);
    } else {
        $pengaduanQuery->whereYear('created_at', $tahun);
    }

    $pengaduanData = $pengaduanQuery
        ->groupBy('month', 'status_id')
        ->get()
        ->groupBy('status_id')
        ->mapWithKeys(function ($items, $status_id) {
            return [$status_id => $items->pluck('count', 'month')->all()];
        });

    $totalPengaduanQuery = Tiket::where('created_by', $userId);

    if ($startDate && $endDate) {
        $totalPengaduanQuery->whereBetween('created_at', [$startDate, $endDate]);
    } else {
        $totalPengaduanQuery->whereYear('created_at', $tahun);
    }

    $totalPengaduanPerMonth = $totalPengaduanQuery
        ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->pluck('count', 'month')
        ->all();

    $months = range(1, 12);
    $monthNames = collect($months)->map(fn($m) => \Carbon\Carbon::create()->month($m)->format('F'))->toArray();

    $dataPerStatus = [];
    foreach ($statuses as $status_id) {
        $dataPerStatus[] = [
            'name' => $statusLabels[$status_id],
            'data' => array_map(fn($m) => $pengaduanData[$status_id][$m] ?? 0, $months),
            'color' => match ($status_id) {
                1 => '#FF6384', 
                2 => '#9966FF', 
                3 => '#4BC0C0',
                4 => '#FFCE56'
            },
        ];
    }

    $cardData = [
        'Total Pengaduan' => array_sum($totalPengaduanPerMonth),
        'Pengaduan Menunggu' => array_sum($pengaduanData[1] ?? []),
        'Pengaduan Diproses' => array_sum($pengaduanData[2] ?? []),
        'Pengaduan Proses Selesai' => array_sum($pengaduanData[4] ?? []),
        'Pengaduan Selesai' => array_sum($pengaduanData[3] ?? []),
    ];

    $years = Tiket::where('created_by', $userId)
        ->selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    $query = Tiket::query()->where('created_by', $userId);

    $prosesSelesaiTickets = $query->where('status_id', 4)
        ->whereYear('created_at', $tahun)
        ->get();
    $prosesSelesaiCount = $query->where('status_id', 4)->count();

    return view('dashboard-pengaduan', compact(
        'cardData',
        'dataPerStatus',
        'tahun',
        'years',
        'monthNames',
        'prosesSelesaiCount',
        'prosesSelesaiTickets',
        'startDate',
        'endDate'
    ));
}










public function sendMessage(Request $request)
{
    $validated = $request->validate([
        'tiket_id' => 'required|exists:tiket,id',
        'content' => 'required|string',
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $tiket = Tiket::find($validated['tiket_id']);
    if (!$tiket) {
        return response()->json(['error' => 'Tiket tidak ditemukan'], 404);
    }

    if ((int) $tiket->status_id !== 2) {
        return response()->json(['error' => 'Tidak dapat mengirim pesan pada tiket ini'], 403);
    }

    $chatMessage = new ChatMessage();
    $chatMessage->tiket_id = $validated['tiket_id'];
    $chatMessage->user_id = Auth::id();
    $chatMessage->content = $validated['content'];

    if ($request->hasFile('lampiran')) {
        $chatMessage->lampiran = $request->file('lampiran')->store('lampiran', 'public');
    }

    $chatMessage->save();

    return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim']);
}





public function getChatMessages($id)
{
    $messages = ChatMessage::where('tiket_id', $id)
        ->with('user') // Memastikan relasi 'user' dipanggil
        ->get()
        ->map(function ($message) {
            $created_at = $message->created_at;
            if ($created_at->isToday()) {
                $time = 'Today ' . $created_at->format('H:i');
            } elseif ($created_at->isYesterday()) {
                $time = 'Yesterday ' . $created_at->format('H:i');
            } else {
                $time = $created_at->toFormattedDateString() . ' - ' . $created_at->format('H:i');
            }

            return [
                'content' => $message->content,
                'user_id' => $message->user_id,
                'user_name' => $message->user->name,
                'created_at' => $time,
                'lampiran' => $message->lampiran ? asset('storage/' . $message->lampiran) : null,
            ];
        });

    return response()->json(['messages' => $messages]);
}



    public function cardTickets($category, $value)
    {
        if (in_array($category, ['status_id', 'prioritas', 'area'])) {
            $tickets = Tiket::where($category, strtolower($value))->get();
        } else {
            $tickets = collect();
        }

        return view('card-tickets', compact('tickets', 'category', 'value'));
    }
}
