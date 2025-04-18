<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tiket;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Help;
use App\Models\Satker;
use App\Models\Permasalahan;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Ambil tahun dari request, default ke tahun ini jika tidak ada
        $selectedYear = $request->input('year', date('Y'));

        // Define the attributes we want to count
        $attributes = [
            'status_id' => [1, 2, 3, 4],
            'prioritas' => ['tinggi', 'sedang', 'rendah'],
            'rating' => [1, 2, 3, 4, 5],
            'area' => ['Kemhan', 'Luar Kemhan'],
        ];

        // Initialize counts
        $counts = [];

        // Count tickets based on defined attributes and filter by selected year
        foreach ($attributes as $key => $values) {
            foreach ($values as $value) {
                $counts[$key][$value] = Tiket::whereYear('created_at', $selectedYear)
                    ->where($key, $value)
                    ->count();
            }
        }

        // Get total users
        $total_users = User::count();

        // Get satker data
        $nama_satker = Tiket::with('satkerData')
            ->selectRaw('count(*) as count, satker')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('satker')
            ->get();
        
        $deskripsi = Tiket::with('permasalahanData')
            ->selectRaw('count(*) as count, permasalahan_id')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('permasalahan_id')
            ->get();

        // Get total tiket
        $total_tiket = Tiket::whereYear('created_at', $selectedYear)->count();

        // Complaints Per Month by Status for the Selected Year
        $months = range(1, 12);
        $statuses = [1, 2, 3, 4];
        $complaintsPerMonth = [];

        foreach ($statuses as $status) {
            $complaintsPerMonth[$status] = [];
            foreach ($months as $month) {
                $count = Tiket::whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $month)
                    ->where('status_id', $status)
                    ->count();
                $complaintsPerMonth[$status][] = $count;
            }
        }

        // Get a list of years from the ticket records
        $years = Tiket::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

            $statusLabels = [
                1 => 'Menunggu',
                2 => 'Diproses',
                3 => 'Selesai',
                4 => 'Proses Selesai'
            ];

        return view('admin', compact(
            'counts',
            'total_users',
            'nama_satker',
            'deskripsi',
            'total_tiket',
            'complaintsPerMonth',
            'selectedYear',
            'years',
            'statusLabels'
        ));
    }




    public function edit($id)
    {
        $user = User::with('satkerData')->findOrFail($id);
        $satkers = Satker::all();
        return view('admin.edit-users', compact('user', 'satkers'));
    }


    public function resetUserPassword($id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Reset password menjadi default "password123"
        $user->password = Hash::make('password123');
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil direset ke default.');
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('users-list')->with('success', 'Pengguna berhasil diperbarui');
    }
    public function createUser()
    {
        return view('admin.create-user');
    }
    public function storeUser(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:User,Technician,Admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Membuat user baru
        $user = new User();
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->password = Hash::make($validatedData['password']);  // Hashing password

        $user->save();  // Simpan ke database

        // Redirect dengan pesan sukses
        return redirect()->route('users-list')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function usersList()
    {   
        $users = User::with('satkerData')->orderBy('created_at', 'desc')->get();
        return view('admin.users-list', compact('users'));
    }
    public function listTiketSemuaUser()
    {
        $tiket = Tiket::with('user')->get();
        $tiket = Tiket::with('permasalahanData')->get();
        $tiket = Tiket::orderBy('created_at', 'desc')->get();
        return view('admin.ticket-list', compact('tiket'));
    }
    
    // Menampilkan list Satker
    public function satkerList()
    {
        $satkers = Satker::all(); // Mengambil semua data Satker
        return view('admin.satker-list', compact('satkers'));
    }

    public function permasalahanList()
    {
        $permasalahan = Permasalahan::all(); 
        return view('admin.permasalahan-list', compact('permasalahan'));
    }

    // Menampilkan form untuk menambah Satker
    public function createSatker()
    {
        return view('admin.create-satker');
    }

    public function createPermasalahan()
    {
        return view('admin.create-permasalahan');
    }

    // Menyimpan Satker baru
    public function storeSatker(Request $request)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
        ]);

        Satker::create([
            'nama_satker' => $request->nama_satker,
        ]);

        return redirect()->route('satker-list')->with('success', 'Satker berhasil ditambahkan!');
    }

    public function storePermasalahan(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
        ]);

        Permasalahan::create([
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('permasalahan-list')->with('success', 'Kategori permasalahan berhasil ditambahkan!');
    }

    // Menampilkan form edit Satker
    public function editSatker($id)
    {
        $satker = Satker::findOrFail($id);
        return view('admin.edit-satker', compact('satker'));
    }

    public function editPermasalahan($id)
    {
        $permasalahan = Permasalahan::findOrFail($id);
        return view('admin.edit-permasalahan', compact('permasalahan'));
    }

    // Mengupdate data Satker
    public function updateSatker(Request $request, $id)
    {
        $request->validate([
            'nama_satker' => 'required|string|max:255',
        ]);

        $satker = Satker::findOrFail($id);
        $satker->update([
            'nama_satker' => $request->nama_satker,
        ]);

        return redirect()->route('satker-list')->with('success', 'Satker berhasil diperbarui!');
    }

    public function updatePermasalahan(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string|max:255',
        ]);

        $permasalahan = Permasalahan::findOrFail($id);
        $permasalahan->update([
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('permasalahan-list')->with('success', 'Kategori permasalahan berhasil diperbarui!');
    }
    // Menghapus Satker
    public function deleteSatker($id)
    {
        $satker = Satker::findOrFail($id);
        $satker->delete();

        return redirect()->route('satker-list')->with('success', 'Satker berhasil dihapus!');
    }

    public function deletePermasalahan($id)
    {
        $permasalahan = Permasalahan::findOrFail($id);
        $permasalahan->delete();

        return redirect()->route('permasalahan-list')->with('success', 'Kategori permasalahan berhasil dihapus!');
    }







    public function homeSettings()
    {
        $faqCategories = Category::whereIn('slug', ['akun', 'aplikasi', 'pengaduan'])->get();
        $helpCategories = Category::whereIn('slug', ['tiket', 'jaringan', 'software', 'hardware'])->get();
        
        return view('admin.home-settings', compact('faqCategories', 'helpCategories'));
    }

    // Store a new FAQ category
    public function storeFaqCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('home-settings')->with('success', 'FAQ Category added successfully');
    }

    // Edit an FAQ category
    public function detailFaqCategory($id)
    {
        $category = Category::findOrFail($id);
        $entries = Faq::where('category_id', $id)->get();
        return view('admin.detail-category', compact('category', 'entries'));
    }

    // Update an FAQ category
    public function updateFaqCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('home-settings')->with('success', 'FAQ Category updated successfully');
    }

    // Delete an FAQ category
    public function deleteFaqCategory($id)
    {
        Category::destroy($id);
        return redirect()->route('home-settings')->with('success', 'FAQ Category deleted successfully');
    }

    // Similar methods for Help Categories
    public function storeHelpCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('home-settings')->with('success', 'Help Category added successfully');
    }

    public function detailHelpCategory($id)
    {
        $category = Category::findOrFail($id);
        $entries = Help::where('category_id', $id)->get();
        return view('admin.detail-category', compact('category', 'entries'));
    }

    public function updateHelpCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
        ]);

        return redirect()->route('home-settings')->with('success', 'Help Category updated successfully');
    }

    public function deleteHelpCategory($id)
    {
        Category::destroy($id);
        return redirect()->route('home-settings')->with('success', 'Help Category deleted successfully');
    }

        // Store a new FAQ category
        public function createFaqEntry($categoryId)
        {
            $category = Category::findOrFail($categoryId);
            return view('admin.create-faq-entry', compact('category'));
        }
    
        public function storeFaqEntry(Request $request, $categoryId)
        {
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
            ]);
    
            Faq::create([
                'category_id' => $categoryId,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
    
            return redirect()->route('faq.category.detail', $categoryId)->with('success', 'FAQ entry added successfully');
        }
    
        public function editFaqEntry($id)
        {
            $faq = Faq::findOrFail($id);
            $category = Category::findOrFail($faq->category_id);
            return view('admin.edit-faq-entry', compact('faq', 'category'));
        }
    
        public function updateFaqEntry(Request $request, $id)
        {
            $faq = Faq::findOrFail($id);
    
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
            ]);
    
            $faq->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
    
            return redirect()->route('faq.category.detail', $faq->category_id)->with('success', 'FAQ entry updated successfully');
        }
    
        public function deleteFaqEntry($id)
        {
            $faq = Faq::findOrFail($id);
            $faq->delete();
    
            return redirect()->route('faq.category.detail', $faq->category_id)->with('success', 'FAQ entry deleted successfully');
        }
    
        public function createHelpEntry($categoryId)
        {
            $category = Category::findOrFail($categoryId);
            return view('admin.create-help-entry', compact('category'));
        }
    
        public function storeHelpEntry(Request $request, $categoryId)
        {
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
            ]);
    
            Help::create([
                'category_id' => $categoryId,
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
    
            return redirect()->route('help.category.detail', $categoryId)->with('success', 'Help entry added successfully');
        }
    
        public function editHelpEntry($id)
        {
            $help = Help::findOrFail($id);
            $category = Category::findOrFail($help->category_id);
            return view('admin.edit-help-entry', compact('help', 'category'));
        }
    
        public function updateHelpEntry(Request $request, $id)
        {
            $help = Help::findOrFail($id);
    
            $request->validate([
                'question' => 'required|string|max:255',
                'answer' => 'required|string',
            ]);
    
            $help->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
    
            return redirect()->route('help.category.detail', $help->category_id)->with('success', 'Help entry updated successfully');
        }
    
        public function deleteHelpEntry($id)
        {
            $help = Help::findOrFail($id);
            $help->delete();
    
            return redirect()->route('help.category.edit', $help->category_id)->with('success', 'Help entry deleted successfully');
        }

        public function processTicket($id)
        {
            $ticket = Tiket::findOrFail($id);
            $technicians = User::whereIn('role', ['Technician', 'Piket'])->get();

            return view('admin.process-ticket', compact('ticket', 'technicians'));
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

            return redirect()->route('admin.ticket-list')->with('success', 'Technician assigned successfully!');
        }
}