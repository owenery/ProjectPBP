<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\BuatIrsController;

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

Route::get('/', function(){
    return view('loginPage');
})->name('loginPage');

Route::post('/', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->get('/selectRole', [AuthController::class, 'showRoleSelectionPage'])->name('selectRole');
Route::middleware(['auth'])->post('/selectRole', [AuthController::class, 'handleRoleSelection'])->name('handleRoleSelection');


// Dashboard Routes for Specific Roles
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/mahasiswa', function () {
        return view('mahasiswa.mahasiswa');
    })->name('mahasiswaDash');

    Route::get('/dashboard/bagianakademik', function () {
        return view('bagianAkademik.bagianakademik');
    })->name('bagianAkademikDash');

    Route::get('/dashboard/dekan', function () {
        return view('dekan.dekan');
    })->name('dekanDash');

    Route::get('/dashboard/kaprodi', function () {
        return view('kaprodi.kaprodi');
    })->name('kaprodiDash');

    Route::get('/dashboard/pembimbingakademik', function () {
        return view('pembimbingAkademik.pembimbingakademik');
    })->name('pembimbingAkademikDash');
});

Route ::get('/dekan/pengajuan_ruangan', function(){
    return view('dekan.pengajuan_ruangan');
});

Route ::get('/dekan/pengajuan_jadwal', function(){
    return view('dekan.pengajuan_jadwal');
});

Route ::get('/bagianAkademik/list_ruang_kuliah', function(){
    return view('bagianAkademik.list_ruang_kuliah');
});

// Route ::get('/bagianAkademik/list_pengajuan_ruang_kuliah', function(){
//     // $ruangs  = DB::table('ruang')-> get();
//     return view('bagianAkademik.list_pengajuan_ruang_kuliah');
// });
use App\Http\Controllers\RuangController;

Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');

// use App\Http\Controllers\BagianAkademikController;

// // Route to show the list of Ruang Kuliah and handle the modal popup
// Route::get('/list-pengajuan-ruang-kuliah', [BagianAkademikController::class, 'showListRuangKuliah'])->name('list.ruang.kuliah');

// // Route to handle the form submission from the modal popup
// Route::post('/submit-ruang-kuliah', [BagianAkademikController::class, 'submitRuangKuliah'])->name('submit.ruang.kuliah');

// Define the route to show the ruang form






Route::get('/buat_irs', [BuatIrsController::class, 'index'])->name('buat_irs');
Route::get('/irs', [IRSController::class, 'index'])->name('irs');
Route::get('/khs', [KHSController::class, 'index'])->name('khs');
Route::middleware('auth')->group(function () {
    // Route untuk halaman utama herregistrasi
    Route::get('/herregistrasi', [HerregistrasiController::class, 'index'])->name('herregistrasi.index');
    
    // Route untuk mengubah status menjadi Aktif
    Route::post('/herregistrasi/aktif', [HerregistrasiController::class, 'setAktif'])->name('herregistrasi.setAktif');
    
    // Route untuk mengubah status menjadi Cuti
    Route::post('/herregistrasi/cuti', [HerregistrasiController::class, 'setCuti'])->name('herregistrasi.setCuti');
    
    // Route untuk membatalkan status
    Route::post('/herregistrasi/batalkan', [HerregistrasiController::class, 'batalkanStatus'])->name('herregistrasi.batalkanStatus');
});

// Bagian Kaprodi
use App\Http\Controllers\KaprodiController;

Route::get('/Dashboard', [KaprodiController::class, 'index']);
Route::get('/TabelMK', [KaprodiController::class, 'tabelmatkul']);
Route::get('/TabelJD', [KaprodiController::class, 'tabeljadwal']);
Route::get('/SusunMK', [KaprodiController::class, 'susunmatkul']);
Route::get('/SusunJD', [KaprodiController::class, 'susunjadwal']);