<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\PiketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');})->name('home');
Route::get('/home', function () {
    return view('home');})->name('home');

Route::get('/faq', [HomeController::class, 'index'])->name('faq');
Route::get('/faq/{slug}', [HomeController::class, 'showCategory'])->name('faq.category');

Route::get('/help', [HomeController::class, 'indexHelp'])->name('help');
Route::get('/help/{slug}', [HomeController::class, 'showCategoryHelp'])->name('help.showCategoryHelp');


Route::get('auth/login', function () {
    return view('login');})->name('login');
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
    return view('daftar-pengaduan');})->name('daftar-pengaduan')->middleware('auth');
Route::get('/profil-saya', function() {
    return view('profil-saya');})->name('profil-saya');
Route::get('/edit-profil', function() {
    return view('edit-profil');})->name('edit-profil')->middleware('auth');
Route::get('/detail-tiket/{id}', [TiketController::class, 'show'])->name('detail-tiket')->middleware('auth');
Route::get('/buat-pengaduan', [TiketController::class, 'create'])->name('buat-pengaduan');


Route::post('/buat-pengaduan', [ TiketController::class, 'buat_pengaduan' ])->name('daftar-pengaduan');
Route::get('/daftar-pengaduan', [TiketController::class, 'daftar_pengaduan'])->name('daftar-pengaduan')->middleware('auth');
Route::get('/history-pengaduan', [TiketController::class, 'history_pengaduan'])->name('history-pengaduan')->middleware('auth');
Route::post('/tutup/{id}', [TiketController::class, 'tutup'])->name('tutup-tiket')->middleware('auth');

Route::get('/profil-saya', [UserController::class, 'showProfil'])->name('showProfil')->middleware('auth');
Route::post('/profil-saya', [UserController::class, 'updateProfile'])->name('profil-saya');
Route::get('/edit-profil', [UserController::class, 'edit'])->name('edit-profil')->middleware('auth');

Route::get('/edit-pengaduan/{id}', [TiketController::class, 'edit'])->name('edit-pengaduan')->middleware('auth');
Route::post('/edit-pengaduan/{id}', [TiketController::class, 'update'])->name('update-pengaduan')->middleware('auth');


Route::get('/rating/{id}', [TiketController::class, 'showRatingForm'])->name('rating-form')->middleware('auth');
Route::post('/rating/{id}', [TiketController::class, 'submitRating'])->name('submit-rating')->middleware('auth');

Route::get('/dashboard-pengaduan', [TiketController::class, 'dashboard'])->name('dashboard-pengaduan')->middleware('auth');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin');

    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');

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
    
    Route::get('/ticket-list', [AdminController::class, 'listTiketSemuaUser'])->name('ticket-list');
    Route::get('/users-list', [AdminController::class, 'usersList'])->name('users-list');

    Route::get('/admin/{id}/process', [AdminController::class, 'processTicket'])->name('ticket.process');
    Route::post('/admin/{id}/assign-technician', [AdminController::class, 'assignTechnician'])->name('ticket.assign-technician');
});

Route::middleware(['auth', 'role:Technician,Admin'])->group(function () {
    Route::view('/technician', 'technisi')->name('technician');
    Route::get('/tasks', [TechnicianController::class, 'task'])->name('tasks');
});

Route::middleware(['auth', 'role:Piket,Admin'])->group(function () {
    Route::get('/piket', [PiketController::class, 'piket'])->name('piket');
    Route::get('piket/tickets', [PiketController::class, 'tickets'])->name('tickets');
    Route::get('/piket/{id}/process', [PiketController::class, 'processTicket'])->name('ticket.process');
    Route::post('/piket/{id}/assign-technician', [PiketController::class, 'assignTechnician'])->name('ticket.assign-technician');
});
