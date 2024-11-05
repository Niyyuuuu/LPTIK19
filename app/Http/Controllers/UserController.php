<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Satker;

class UserController extends Controller
{
    public function showprofil()
    {
        $satkers = Satker::all();
        $user = Auth::user();
        return view('profil-saya', compact('satkers', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:25|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|string|unique:users,username,' . $user->id,
            'satker' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255|unique:users,contact,' . $user->id,
            'nip' => 'nullable|string|max:255|unique:users,nip,' . $user->id,
        ]);

        // Update profil user dengan mass assignment
            $user = User::where('id', $user->id)->update($validatedData);

            return redirect('profil-saya')->with('success', 'Profil berhasil diperbarui!');
    }

    public function edit()
    {
        $satkers = Satker::all();
        $user = Auth::user();
        return view('edit-profil', compact('satkers', 'user'));
    }
}
