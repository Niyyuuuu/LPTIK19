<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmailNotification;

class AuthController extends Controller
{
    public function verifyEmail(Request $request, $id, $hash) 
    {
        $user = User::findOrFail($id);

        // Validasi hash
        if ($hash !== sha1($user->getEmailForVerification())) {
            return redirect()->route('login')->with('error', 'Link verifikasi tidak valid.');
        }

        // Cek apakah email sudah diverifikasi
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email Anda sudah diverifikasi.');
        }

        // Tandai email sebagai terverifikasi
        $user->markEmailAsVerified();

        return redirect()->route('login')->with('success', 'Berhasil! Email Anda telah diverifikasi.');
    }
    
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('login')->with('success', 'Email Anda sudah diverifikasi.'); }
        Notification::send($request->user(), new VerifyEmailNotification());
        return back()->with('success', 'Email verifikasi telah dikirimkan. Silakan cek email Anda.');
    }

    public function showVerificationNotice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(route('login'))
            : view('auth.verify-email');  
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|captcha',
        ],
        [
            'captcha.required' => 'Please enter the captcha.',
            'captcha.captcha' => 'The CAPTCHA code is incorrect.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $validate = $validator->validated();


        // Mencari pengguna berdasarkan username
        $user = User::where('username', $validate['username'])->first();

        if (!$user || !Hash::check($validate['password'], $user->password)) {
            return redirect()->route('login')
                ->with('fails', 'Username atau password salah')
                ->withInput($request->except('password'));
        }

        $ticketsToClose = Tiket::where('status_id', 4)
        ->where('updated_at', '<=', Carbon::now()->subDays(2))  // Mengubah tiket yang sudah lebih dari 2 hari
        ->get();

    // Ubah status tiket yang sudah lebih dari 2 hari menjadi 'Selesai' (status_id = 3)
        foreach ($ticketsToClose as $ticket) {
            $ticket->status_id = 3;  // Set status menjadi 'Selesai'
            $ticket->save();
        }
        
        Auth::login($user);
        // Redirect berdasarkan peran
        switch ($user->role) {
            case 'Admin':
                return redirect()->route('admin')->with('success', 'Berhasil! Anda telah login sebagai Admin.');
            case 'Technician':
                return redirect()->route('technician')->with('success', 'Berhasil! Anda telah login sebagai Teknisi.');
            case 'User': // Pastikan menambahkan bagian ini untuk user
                return redirect()->route('dashboard-pengaduan')->with('success', 'Berhasil! Anda telah login dengan sukses.');                    
            case 'Piket':
                return redirect()->route('piket')->with('success', 'Berhasil! Anda telah login sebagai Piket.');
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed'
        ], [
            'password.min' => 'Password terlalu pendek.',
            'password.confirmed' => 'Password tidak cocok.',
            'email.unique' => 'Email sudah terdaftar.',
            'username.unique' => 'Username sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validate = $validator->validated();
        $user = User::create([
            'name' => $validate['name'],
            'username' => $validate['username'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'role' => 'User',
        ]);

        Notification::send($user, new VerifyEmailNotification());


        return redirect()->route('login')->with('success', 'Berhasil! Silakan cek email Anda untuk verifikasi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Berhasil! Anda telah logout dengan sukses.');
    }

    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
