<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
// use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ListUserController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ListPasienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login Akun
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.authenticate');
// Register Akun
// Route::get('/register', [LoginController::class, 'register'])->name('register');
// Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');


Route::middleware(['auth'])->group(function () {
    // Fungsi Menu Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Fungsi Menu Tampilan Pemetaan Lokasi 
    Route::get('/pemetaan-lokasi', [LokasiController::class, 'index'])->name('pemetaan-lokasi');
    // Fungsi Menu Manajemen Lokasi
    Route::get('/manajemen-lokasi', [LokasiController::class, 'manajemen'])->name('manajemen-lokasi');
    // Tambah Lokasi
    Route::get('/lokasi/create', [LokasiController::class, 'create'])->name('lokasi.create');
    Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
    // Edit Lokasi
    Route::get('/lokasi/{id}/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
    // Delete Lokasi
    Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

    // Fungsi Menu Manajemen Pasien
    Route::get('/list-pasien', [ListPasienController::class, 'index'])->name('list-pasien');
    // Fungsi Menu Manajemen Pasien
    Route::get('/list-pasien/{id}', [ListPasienController::class, 'lokasipasien'])->name('list-pasien-lokasi');
    // Fungsi Tambah Data Pasien  
    Route::get('/tambah-pasien', [ListPasienController::class, 'tambah'])->name('tambah-pasien');
    // Route untuk menyimpan data pasien
    Route::post('/simpan-pasien', [ListPasienController::class, 'simpan'])->name('simpan-pasien');
    // Edit Pasien
    Route::get('/edit-pasien/{id}', [ListPasienController::class, 'edit'])->name('edit-pasien');
    // Update Pasien
    Route::put('/update-pasien/{id}', [ListPasienController::class, 'update'])->name('update-pasien');
    // Delete Pasien
    Route::delete('/list-pasien/{id}', [ListPasienController::class, 'destroy'])->name('list-pasien.destroy');

    // Info Data Pengukuran Pasien
    Route::get('/detail-pengukuran/{id}', [PasienController::class, 'index'])->name('detail-pengukuran');
    // Fungsi Tambah Data
    Route::get('/tambah-pengukuran/{id}', [PasienController::class, 'tambah'])->name('tambah-pengukuran');
    Route::post('/tambah-pengukuran/{id}', [PasienController::class, 'simpan'])->name('simpan-pengukuran');
    // Edit Data
    Route::get('/edit-pengukuran/{id}', [PasienController::class, 'edit'])->name('edit-pengukuran');
    Route::put('/edit-pengukuran/{id}', [PasienController::class, 'update'])->name('update-pengukuran');
    // Hapus Data 
    Route::delete('/delete-pengukuran/{id}', [PasienController::class, 'delete'])->name('delete-pengukuran');

    // Fungsi Menu Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
    // Fungsi Menu Manajemen Role User
    Route::get('/list-user', [ListUserController::class, 'index'])->name('list-user');
    // Fungsi Edit User
    Route::get('/list-user/{id}/edit', [ListUserController::class, 'edit'])->name('list-user.edit');
    // Fungsi Update User
    Route::put('/list-user/{id}', [ListUserController::class, 'update'])->name('list-user.update');
    // Tambah Role User
    Route::get('/list-user/create', [ListUserController::class, 'create'])->name('list-user.create');
    Route::post('/list-user/store', [ListUserController::class, 'store'])->name('list-user.store');
    // Fungsi Hapus User
    Route::delete('/list-user/{id}', [ListUserController::class, 'destroy'])->name('list-user.destroy');

});