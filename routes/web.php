<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\RekapAplikasiController;
use App\Http\Controllers\ViewAplikasiController;
use App\Models\RekapAplikasi;

Route::get('/', function () {
    return view('selamat-datang');
});

// bagian ini untuk rute authentikasi
//
// start
Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);
Route::get('/opd/dashboard', [\App\Http\Controllers\OpdController::class, 'dashboard'])
    ->name('opd.dashboard')
    ->middleware(['auth', 'role:opd']);
Route::get('/user/dashboard', [\App\Http\Controllers\UserController::class, 'dashboard'])
    ->name('user.dashboard')
    ->middleware(['auth', 'role:user']);

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'opd') {
        return redirect()->route('opd.dashboard');
    } else {
        return redirect()->route('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');
// end

// Bagian ini untuk view pages
//
// start
// Route::get('/rekap-assessment-1', [ViewAplikasiController::class, 'dashboard']);
Route::get('/rekap-aplikasi-view', [ViewAplikasiController::class, 'rekap']);
Route::get('/assessment', [ViewAplikasiController::class, 'assessment']);
Route::get('/development', [ViewAplikasiController::class, 'development']);
Route::get('/selesai', [ViewAplikasiController::class, 'selesai']);
Route::get('/akses-server', [ViewAplikasiController::class, 'aksesServer']);
//end

// bagian ini untuk rute list-apk
//
// start
Route::get('/admin/list-apk', [\App\Http\Controllers\AdminController::class, 'listApk'])
    ->name('admin.list-apk')
    ->middleware(['auth', 'role:admin']);
//end

// bagian ini untuk from aplikasi baru -> list-apk
//
// start
Route::post('/admin/aplikasi', [\App\Http\Controllers\AdminController::class, 'store'])
    ->name('admin.aplikasi.store')
    ->middleware(['auth', 'role:admin']);
//end

// bagian ini untuk edit aplikasi -> list-apk
//
// start
Route::get('/admin/edit-apk', [\App\Http\Controllers\AdminController::class, 'editApk'])
    ->name('admin.edit-apk')
    ->middleware(['auth', 'role:admin']);
//end

// bagian ini untuk edit role Secara keseluruha mulai dari masuk ke halaman list akun dan edit akun yang ada
//
// start
Route::get('/admin/edit-role', [\App\Http\Controllers\AdminController::class, 'editRole'])
    ->name('admin.edit-role')
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/users/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])
    ->name('users.edit')
    ->middleware(['auth', 'role:admin']);

Route::put('/admin/users/{id}/update-role', [\App\Http\Controllers\AdminController::class, 'updateRole'])
    ->name('users.updateRole')
    ->middleware(['auth', 'role:admin']);

//end

// bagian ini untuk tambah pengajuan assessment
//
// start
Route::get('/opd.form-pengajuan-assessment', [\App\Http\Controllers\OpdController::class, 'formPengajuan'])
    ->name('opd.form-pengajuan-assessment')
    ->middleware(['auth', 'role:opd']);
//end

// bagian ini untuk melihat daftar pengajuan assessment
//
// start
Route::get('/opd.daftar-pengajuan-assessment', [\App\Http\Controllers\OpdController::class, 'daftarPengajuan'])
    ->name('opd.daftar-pengajuan-assessment')
    ->middleware(['auth', 'role:opd']);
//end

// bagian ini untuk edit akun pribadi -> template laravel blade
//
// start
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//end

// Mulai ke bawah untuk CRUD
//
// start
//
// Untuk Role Admin
//
Route::resource('/rekap-aplikasi', RekapAplikasiController::class);
//
// routes/web.php
Route::get('/admin/list-apk', [RekapAplikasiController::class, 'index'])->name('admin.list-apk');
//
// routes/web.php
Route::get('/rekap-aplikasi/{id}/edit', [RekapAplikasiController::class, 'edit'])->name('rekap-aplikasi.edit');
//
// Verify your routes/web.php
Route::put('/rekap-aplikasi/{id}', [RekapAplikasiController::class, 'update'])->name('rekap-aplikasi.update');
require __DIR__.'/auth.php';
//
Route::get('admin/rekap-aplikasi', [RekapAplikasiController::class, 'index'])->name('rekap-aplikasi.index');
//
// Untuk Role OPD
//
Route::post('/rekap-aplikasi/storeAssessment', [RekapAplikasiController::class, 'storeAssessment'])->name('rekap-aplikasi.storeAssessment');
//
Route::middleware(['auth', 'role:opd'])->group(function () {
    Route::post('/pengajuan-assessment/store', [RekapAplikasiController::class, 'storeAssessment'])->name('pengajuan-assessment.storeAssessment');
});
//
Route::get('/assessment/create', [RekapAplikasiController::class, 'createAssessment'])->name('rekap-aplikasi.createAssessment');
//
Route::get('opd/rekap-aplikasi', [RekapAplikasiController::class, 'indexAssessment'])->name('rekap-aplikasi.indexAssessment');
//
// end

// Bagian ini untuk fungsi approve pengajuan OPD oleh user
//
// Start
//
// User
Route::middleware('auth')->group(function () {
    Route::get('/pengajuan-opd', [\App\Http\Controllers\UserController::class, 'showPengajuanForm'])->name('user.pengajuan.form');
    Route::post('/pengajuan-opd', [\App\Http\Controllers\UserController::class, 'submitPengajuan'])->name('user.pengajuan.submit');
});

// Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/admin/pengajuan-opd', [\App\Http\Controllers\AdminController::class, 'daftarPengajuanOPD'])->name('admin.pengajuan-opd');
    Route::post('/admin/pengajuan-opd/{id}/approve', [\App\Http\Controllers\AdminController::class, 'approvePengajuan'])->name('admin.pengajuan-opd.approve');
    Route::post('/admin/pengajuan-opd/{id}/reject', [\App\Http\Controllers\AdminController::class, 'rejectPengajuan'])->name('admin.pengajuan-opd.reject');
});
//
// end

// bagian ini untuk mencoba melakukan soft delete
//
// start
//
// Route to view trashed applications
Route::get('/rekap-aplikasi/trash', [RekapAplikasiController::class, 'trash'])->name('rekap-aplikasi.trash');

// Route to restore a trashed application
Route::post('/rekap-aplikasi/{id}/restore', [RekapAplikasiController::class, 'restore'])->name('rekap-aplikasi.restore');

// Route to permanently delete a trashed application
Route::delete('/rekap-aplikasi/{id}/force-delete', [RekapAplikasiController::class, 'forceDelete'])->name('rekap-aplikasi.force-delete');
//
// end
