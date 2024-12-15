<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\PiketController;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Captcha;

Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->name('verification.send');
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');

Route::get('/', function () {
    return view('home');})->name('home');
Route::get('/home', function () {
    return view('home');})->name('home');

Route::get('/faq', [HomeController::class, 'index'])->name('faq');
Route::get('/faq/{slug}', [HomeController::class, 'showCategory'])->name('faq.category');

Route::get('/help', [HomeController::class, 'indexHelp'])->name('help');
Route::get('/help/{slug}', [HomeController::class, 'showCategoryHelp'])->name('help.showCategoryHelp');


Route::get('auth/login', function (Captcha $captcha) {
    // Generate CAPTCHA image and its code
    $captchaCode = $captcha->create('default');
    $captchaImage = $captcha->src($captchaCode);

    // Store CAPTCHA code in session
    session(['captcha' => $captchaCode]);

    // Pass the CAPTCHA image URL to the view
    return view('login', ['captchaImage' => $captchaImage]);
})->name('login');

Route::post('auth/login', [AuthController::class, 'login'])->name('login-proses');


Route::get('auth/register', function() {
    return view('register'); })->name('register');
Route::post('auth/login', [ AuthController::class, 'login' ])->name('login-proses');
Route::post('auth/register', [ AuthController::class, 'register' ])->name('register-proses');
Route::get('auth/logout', [ AuthController::class, 'logout' ])->name('logout');

Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/daftar-pengaduan', function() {
    return view('daftar-pengaduan');})->name('daftar-pengaduan')->middleware('auth', 'verified');
Route::get('/profil-saya', function() {
    return view('profil-saya');})->name('profil-saya')->middleware('auth', 'verified');
Route::get('/edit-profil', function() {
    return view('edit-profil');})->name('edit-profil')->middleware('auth', 'verified');
Route::get('/detail-tiket/{id}', [TiketController::class, 'show'])->name('detail-tiket')->middleware('auth', 'verified');
Route::post('/tickets/{id}/reprocess', [TiketController::class, 'reprocess'])->name('tickets.reprocess');
Route::get('/buat-pengaduan', [TiketController::class, 'create'])->name('buat-pengaduan')->middleware('auth', 'verified');


Route::post('/tiket/send-message', [TiketController::class, 'sendMessage'])->name('send-message')->middleware('auth', 'verified');
Route::get('/tiket/chat-messages/{id}', [TiketController::class, 'getChatMessages'])->name('chat-messages')->middleware('auth', 'verified');


Route::post('/buat-pengaduan', [ TiketController::class, 'buat_pengaduan' ])->name('daftar-pengaduan')->middleware('auth', 'verified');
Route::get('/daftar-pengaduan', [TiketController::class, 'daftar_pengaduan'])->name('daftar-pengaduan')->middleware('auth', 'verified');
Route::get('/history-pengaduan', [TiketController::class, 'history_pengaduan'])->name('history-pengaduan')->middleware('auth', 'verified');
Route::post('/tutup/{id}', [TiketController::class, 'tutup'])->name('tutup-tiket')->middleware('auth', 'verified');
Route::delete('/hapus-tiket/{id}', [TiketController::class, 'destroy'])->name('hapus-tiket')->middleware('auth', 'verified');

Route::get('/profil-saya', [UserController::class, 'showProfil'])->name('showProfil')->middleware('auth', 'verified');
Route::post('/profil-saya', [UserController::class, 'updateProfile'])->name('profil-saya')->middleware('auth', 'verified');
Route::get('/edit-profil', [UserController::class, 'edit'])->name('edit-profil')->middleware('auth', 'verified');

Route::get('/edit-pengaduan/{id}', [TiketController::class, 'edit'])->name('edit-pengaduan')->middleware('auth', 'verified');
Route::post('/edit-pengaduan/{id}', [TiketController::class, 'update'])->name('update-pengaduan')->middleware('auth', 'verified');


Route::get('/rating/{id}', [TiketController::class, 'showRatingForm'])->name('rating-form')->middleware('auth', 'verified');
Route::post('/rating/{id}', [TiketController::class, 'submitRating'])->name('submit-rating')->middleware('auth', 'verified');

Route::get('/dashboard-pengaduan', [TiketController::class, 'dashboard'])->name('dashboard-pengaduan')->middleware('auth', 'verified');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');
    
    Route::get('/users-list', [AdminController::class, 'usersList'])->name('users-list');
    Route::get('/admin/create-user', [AdminController::class, 'createUser'])->name('create-user');
    Route::post('/admin/store-user', [AdminController::class, 'storeUser'])->name('store-user');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('/admin/reset-password/{id}', [AdminController::class, 'resetUserPassword'])->name('admin.reset-password');

    Route::get('/home-settings', [AdminController::class, 'homeSettings'])->name('home-settings');
    Route::post('/faq/category/store', [AdminController::class, 'storeFaqCategory'])->name('faq.category.store');
    Route::get('/faq/category/detail/{id}', [AdminController::class, 'detailFaqCategory'])->name('faq.category.detail');
    Route::post('/faq/category/update/{id}', [AdminController::class, 'updateFaqCategory'])->name('faq.category.update');
    Route::delete('/faq/category/delete/{id}', [AdminController::class, 'deleteFaqCategory'])->name('faq.category.delete');

    Route::post('/help/category/store', [AdminController::class, 'storeHelpCategory'])->name('help.category.store');
    Route::get('/help/category/detail/{id}', [AdminController::class, 'detailHelpCategory'])->name('help.category.detail');
    Route::post('/help/category/update/{id}', [AdminController::class, 'updateHelpCategory'])->name('help.category.update');
    Route::delete('/help/category/delete/{id}', [AdminController::class, 'deleteHelpCategory'])->name('help.category.delete');
    
    Route::get('admin/faq/{categoryId}/create-entry', [AdminController::class, 'createFaqEntry'])->name('faq.entry.create');
    Route::post('admin/faq/{categoryId}/store-entry', [AdminController::class, 'storeFaqEntry'])->name('faq.entry.store');
    Route::get('admin/faq/entry/{id}/edit', [AdminController::class, 'editFaqEntry'])->name('faq.entry.edit');
    Route::put('admin/faq/entry/{id}', [AdminController::class, 'updateFaqEntry'])->name('faq.entry.update');
    Route::delete('admin/faq/entry/{id}', [AdminController::class, 'deleteFaqEntry'])->name('faq.entry.delete');

    Route::get('admin/help/{categoryId}/create-entry', [AdminController::class, 'createHelpEntry'])->name('help.entry.create');
    Route::post('admin/help/{categoryId}/store-entry', [AdminController::class, 'storeHelpEntry'])->name('help.entry.store');
    Route::get('admin/help/entry/{id}/edit', [AdminController::class, 'editHelpEntry'])->name('help.entry.edit');
    Route::put('admin/help/entry/{id}', [AdminController::class, 'updateHelpEntry'])->name('help.entry.update');
    Route::delete('admin/help/entry/{id}', [AdminController::class, 'deleteHelpEntry'])->name('help.entry.delete');

    Route::get('/satker-list', [AdminController::class, 'satkerList'])->name('satker-list');
    Route::get('/create-satker', [AdminController::class, 'createSatker'])->name('create-satker');
    Route::post('/store-satker', [AdminController::class, 'storeSatker'])->name('store-satker');
    Route::get('/edit-satker/{id}', [AdminController::class, 'editSatker'])->name('edit-satker');
    Route::post('/update-satker/{id}', [AdminController::class, 'updateSatker'])->name('update-satker');
    Route::delete('/delete-satker/{id}', [AdminController::class, 'deleteSatker'])->name('delete-satker');

    Route::get('/permasalahan-list', [AdminController::class, 'permasalahanList'])->name('permasalahan-list');
    Route::get('/create-permasalahan', [AdminController::class, 'createPermasalahan'])->name('create-permasalahan');
    Route::post('/store-permasalahan', [AdminController::class, 'storePermasalahan'])->name('store-permasalahan');
    Route::get('/edit-permasalahan/{id}', [AdminController::class, 'editPermasalahan'])->name('edit-permasalahan');
    Route::post('/update-permasalahan/{id}', [AdminController::class, 'updatePermasalahan'])->name('update-permasalahan');
    Route::delete('/delete-permasalahan/{id}', [AdminController::class, 'deletePermasalahan'])->name('delete-permasalahan');
    
    Route::get('/admin/ticket-list', [AdminController::class, 'listTiketSemuaUser'])->name('admin.ticket-list');

    Route::get('/admin/{id}/process', [AdminController::class, 'processTicket'])->name('ticket.process');
    Route::post('/admin/{id}/assign-technician', [AdminController::class, 'assignTechnician'])->name('ticket.assign-technician');
});

Route::middleware(['auth', 'role:Technician,Admin'])->group(function () {
    Route::get('/technician', [TechnicianController::class, 'index'])->name('technician');
    Route::get('/tasks', [TechnicianController::class, 'task'])->name('tasks');
    Route::get('/ticket-list', [TechnicianController::class, 'ticketList'])->name('technisian.ticket-list');
    Route::get('/tutup-tiket-teknisi/{id}', [TechnicianController::class, 'tutupTiket'])->name('tutup-tiket-teknisi');
    Route::post('/tickets/{id}/update-technisian', [TechnicianController::class, 'updateTechnisian'])->name('update-technisian');
});

Route::middleware(['auth', 'role:Piket,Admin'])->group(function () {
    Route::get('/piket', [PiketController::class, 'piket'])->name('piket');
    Route::get('piket/tickets', [PiketController::class, 'tickets'])->name('tickets');
    Route::get('piket/feedback', [PiketController::class, 'feedback'])->name('piket.feedback');
    Route::get('/piket/{id}/edit-tickets', [PiketController::class, 'edit'])->name('edit-tickets');
    Route::put('/piket/{id}/update-tickets', [PiketController::class, 'update'])->name('update-tickets');
    Route::get('/piket/{id}/process', [PiketController::class, 'processTicket'])->name('process-ticket');
    Route::post('/piket/{id}/assign-technician', [PiketController::class, 'assignTechnician'])->name('piket.assign-technician');
});

Route::middleware(['auth', 'role:Admin,Technician,Piket'])->group(function () { 
    Route::get('/card-tickets/{category}/{value}', [TiketController::class, 'cardTickets'])->name('card-tickets');

});
