<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IRSController;
use App\Http\Controllers\KHSController;
use App\Http\Controllers\BuatIrsController;
use App\Http\Controllers\HerregistrasiController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\PAController;
use App\Http\Controllers\inputMKController;
use App\Http\Controllers\inputJDController;
use App\Http\Controllers\KaprodiController;


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

Route::middleware(['auth'])->get('daftarIRS', [PAController::class, 'showUnverifiedIRS'])->name('showVerif');
Route::middleware(['auth'])->get('verifIRS/{nim}/{smt}', [PAController::class, 'isiIRS'])->name('verifIRS');
Route::middleware(['auth'])->post('daftarIRS', [PAController::class, 'IRSterverifikasi'])->name('IRSterverifikasi');
Route::middleware(['auth'])->get('lihatKHS/{nim}/{smt}', [PAController::class, 'KHS'])->name('lihatKHS');

// Dashboard Routes for Specific Roles
Route::middleware(['auth'])->group(function () {
    // Route::get('/dashboard/mahasiswa', function () {
    //     return view('mahasiswa.mahasiswa');
    // })->name('mahasiswaDash');

    Route::get('/dashboard/mahasiswa', [DashboardMahasiswaController::class, 'index'])->name('dashboard');

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

;
use App\Http\Controllers\RuangController;

use App\Models\jadwal;

Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
use App\Http\Controllers\JadwalController;

// Route for displaying the list of jadwals (Pengajuan Jadwal Kuliah)
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

// Route for updating the status of a specific jadwal
Route::post('/jadwal/{id}/update-status', [JadwalController::class, 'updateStatus'])->name('jadwal.updateStatus');  


use App\Http\Controllers\UpdateStatusRuangController;

// Route untuk menampilkan daftar pengajuan ruang
Route::get('/dekan/ruang',[UpdateStatusRuangController::class, 'index'])->name('ruang.index');

// Route untuk menyetujui atau menolak pengajuan ruang
Route::put('/ruang/{id}/status', [UpdateStatusRuangController::class, 'updateStatus'])->name('ruang.updateStatus');





Route::get('/buat_irs', [BuatIrsController::class, 'index'])->name('buat_irs');
Route::get('/irs', [IRSController::class, 'index'])->name('irs');
Route::get('/khs', [KHSController::class, 'index'])->name('khs');
Route::middleware('auth')->get('/dashboard/mahasiswa', [DashboardMahasiswaController::class, 'index'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/herregistrasi', [HerregistrasiController::class, 'index'])->name('herregistrasi.index');
    Route::post('/herregistrasi/update', [HerregistrasiController::class, 'updateStatus'])->name('herregistrasi.update');
});

// Bagian Kaprodi

Route::get('/Dashboard', [KaprodiController::class, 'index']);
Route::get('/TabelMK', [KaprodiController::class, 'tabelmatkul']);
Route::get('kaprodi/TabelJD', [KaprodiController::class, 'tabeljadwal'])->name('kaprodi.tablejadwal');
Route::get('/SusunMK', [KaprodiController::class, 'susunmatkul']);
Route::get('kaprodi/SusunJD', [KaprodiController::class, 'susunjadwal'])->name('kaprodi.susunjadwal');
Route::resource('/kaprodi/inputMK', inputMKController::class);
Route::post('/kaprodi/susunmatkul/store',[KaprodiController::class, 'store']);
Route::resource('/kaprodi/inputJD', inputJDController::class);

