<?php

use App\Http\Controllers\ApproveController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\ArsipKaryawanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoghistoryConttroller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterLemari;
use App\Http\Controllers\MasterRakController;
use App\Http\Controllers\MasterSubKategoriController;
use App\Http\Controllers\MasterTujuanController;
use App\Http\Controllers\MasterTypeController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\PengajuanModel;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\PetugasMiddleware;

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Middleware untuk pimpinan
Route::middleware(['auth', 'pimpinan'])->group(function () {
    Route::get('/dashboardpimpinan', function () {
        return view('dashboard.pimpinan');
    });
    Route::get('menuunduh', [LoghistoryConttroller::class, 'fungsimenuunduh']);

});

// Middleware untuk petugas
Route::middleware(['auth', 'petugas'])->group(function () {
    Route::get('/dashboardpetugas', function () {
        return view('dashboard.petugas');
    });

});

// // Middleware untuk user
Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/dashboarduser', function () {
        return view('dashboard.user');
    });
    Route::resource('arsipkaryawan', PengajuanController::class);

});

// Middleware untuk Gabungan Pimpinan Petugas
Route::middleware(['auth', 'petugaspimpinan'])->group(function () {
    // Route::resource('menuuser', UserController::class);
    Route::resource('menukategori', KategoriController::class);
    // Route::put('/menukategori/{id}', [KategoriController::class, 'update'])->name('menukategori.update');

    Route::resource('menupetugas', PetugasController::class);
    Route::resource('mastertype', MasterTypeController::class);
    // Route::put('/mastertype/{id}', [MasterTypeController::class, 'update'])->name('mastertype.update');

    Route::resource('mastertujuan', MasterTujuanController::class);
    // Route::put('/mastertujuan/{id}', [MasterTujuanController::class, 'update'])->name('mastertujuan.update');

    Route::resource('menuarsip', ArsipController::class);
    // Route::put('/menuarsip/{id}', [ArsipController::class, 'update'])->name('menuarsip.update');

    Route::resource('menuapprove', ApproveController::class);
    Route::resource('menuuser', UserController::class);
    // Route::put('/menuuser/{id}', [UserController::class, 'update'])->name('menuuser.update');


    Route::get('/approvals', [ApproveController::class, 'index'])->name('approvals.index');

    Route::resource('mastersubkategori', MasterSubKategoriController::class);
    Route::resource('masterlemari', MasterLemari::class);
    Route::resource('mastersubkategori', MasterSubKategoriController::class);
    
    
// Petugas approve peminjaman
Route::put('/approvals/{id}/approve', [ApproveController::class, 'approve'])->name('approvals.approve');
Route::put('/approvals/reject/{id}', [ApproveController::class, 'reject'])->name('approvals.reject');
Route::put('/approvals/return/{id}', [ApproveController::class, 'return'])->name('approvals.return');

// Approval tahap 2
Route::put('/approvals2/approve/{id}', [ApproveController::class, 'approve2'])->name('approvals2.approve');
Route::put('/approvals2/reject{id}', [ApproveController::class, 'reject2'])->name('approvals2.reject');

    
});


    

Route::resource('loghistory', LoghistoryConttroller::class);
Route::get('loghistoryall', [LoghistoryConttroller::class, 'logall']);

Route::get('/logpengajuan', [PengajuanController::class, 'menampilkan'])->name('pengajuan.menunggu');
Route::put('/approvals/{id}/approve', [PengajuanController::class, 'approve'])->name('approvals.approve');



Route::get('/preview/{id}', [PengajuanController::class, 'preview'])->name('preview.pdf');

Route::get('/profile', [UserController::class, 'showprofile'])->name('profile.showprofile');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

Route::get('/comingsoon', function () {
    return view('dashboard.coming');
});

// generate pengajuan digital

Route::get('/getSubKategori/{id}', [KategoriController::class, 'getSubKategori']);
Route::get('/getArsipBySubKategori/{id}', [KategoriController::class, 'getArsipBySubKategori']);
Route::get('/getArsipByKategori/{id}', [KategoriController::class, 'getArsipByKategori']);

// generate pengajuan fisik
Route::get('/get-arsip-fisik', [KategoriController::class, 'getArsipFisik']);
Route::get('/get-arsip-details/{nama}', [KategoriController::class, 'getArsipDetails']);

// Route::get('/pengajuan/download/{id}', [LoghistoryConttroller::class, 'downloadFile'])->name('pengajuan.download');
Route::get('/download', [LoghistoryConttroller::class, 'downloadFile'])->name('pengajuan.download');
Route::get('/download-zip', [LoghistoryConttroller::class, 'downloadFileZip'])->name('arsip.download.zip');

// Route untuk mengambil data permintaan approve (notifikasi)
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
