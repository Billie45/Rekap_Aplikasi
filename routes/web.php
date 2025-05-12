<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\RekapAplikasiController;
use App\Http\Controllers\UndanganController;
use App\Http\Controllers\ViewAplikasiController;
use App\Models\RekapAplikasi;

// ============================================================
// Landing Page
// ============================================================
//
// Start
Route::get('/', function () {
    return view('selamat-datang');
});
//
// end

// ============================================================
// bagian ini untuk rute authentikasi
// ============================================================
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
//
// end

// ============================================================
// Bagian ini untuk view pages
// ============================================================
//
// start
Route::get('/rekap-aplikasi-view', [ViewAplikasiController::class, 'rekap'])->name('rekap-aplikasi-view');
Route::get('/assessment', [ViewAplikasiController::class, 'assessment'])->name('assessment');
Route::get('/development', [ViewAplikasiController::class, 'development'])->name('development');
Route::get('/selesai', [ViewAplikasiController::class, 'selesai'])->name('selesai');
Route::get('/akses-server', [ViewAplikasiController::class, 'aksesServer'])->name('akses-server');

Route::get('/assessment/{id}', [ViewAplikasiController::class, 'show_assessmet'])->name('pages.details.show-assessment');
Route::get('/rekap-aplikasi-view/{id}', [ViewAplikasiController::class, 'show_rekap'])->name('pages.details.show-rekap');
Route::get('/development/{id}', [ViewAplikasiController::class, 'show_development'])->name('pages.details.show-development');
Route::get('/selesai/{id}', [ViewAplikasiController::class, 'show_selesai'])->name('pages.details.show-selesai');
//
//end

// ============================================================
// bagian ini untuk rute list-apk
// ============================================================
//
// start
Route::get('/admin/list-apk', [AdminController::class, 'listApk'])
    ->name('admin.list-apk')
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/show-apk/{id}', [AdminController::class, 'showApk'])
    ->name('admin.show-apk')
    ->middleware(['auth', 'role:admin']);

Route::get('/opd/show-apk/{id}', [OpdController::class, 'showApk'])
    ->name('opd.show-apk')
    ->middleware(['auth', 'role:opd']);
//
//end

// ============================================================
// bagian ini untuk from aplikasi baru -> list-apk
// ============================================================
//
// start
Route::post('/admin/aplikasi', [\App\Http\Controllers\AdminController::class, 'store'])
    ->name('admin.aplikasi.store')
    ->middleware(['auth', 'role:admin']);
//
//end

// ============================================================
// bagian ini untuk edit aplikasi -> list-apk
// ============================================================
//
// start
Route::get('/admin/edit-apk', [\App\Http\Controllers\AdminController::class, 'editApk'])
    ->name('admin.edit-apk')
    ->middleware(['auth', 'role:admin']);
//
//end

// ============================================================
// bagian ini untuk edit role Secara keseluruhan
// ============================================================
// mulai dari masuk ke halaman list akun dan edit akun yang ada
// ============================================================
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
//
//end

// ============================================================
// bagian ini untuk tambah pengajuan assessment
// ============================================================
//
// start
Route::get('/opd.form-pengajuan-assessment', [\App\Http\Controllers\OpdController::class, 'formPengajuan'])
    ->name('opd.form-pengajuan-assessment')
    ->middleware(['auth', 'role:opd']);
//
//end

// ======================================================================
// Fungsi untuk verifikasi pengajuan assessment oleh admin
// ======================================================================
//
// Start
//
// Verifikasi oleh admin
Route::post('/rekap-aplikasi/verifikasi/{id}', [RekapAplikasiController::class, 'verifikasi'])->name('rekap-aplikasi.verifikasi');
Route::post('/aplikasi/verifikasi/{id}', [RekapAplikasiController::class, 'verifikasi'])->name('aplikasi.verifikasi');

// Ajukan revisi oleh OPD
Route::get('/aplikasi/revisi/{id}', [RekapAplikasiController::class, 'ajukanRevisi'])->name('aplikasi.revisi');

Route::post('/assessment/{id}/terima', [RekapAplikasiController::class, 'terima'])->name('assessment.terima');
Route::post('/assessment/{id}/tolak', [RekapAplikasiController::class, 'tolak'])->name('assessment.tolak');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route untuk menampilkan form revisi (GET)
    Route::get('/assessment/{id}/revisi', [RekapAplikasiController::class, 'showRevisiForm'])
         ->name('assessment.revisi');

    // Route untuk menyimpan revisi (PUT)
    Route::put('/assessment/{id}/revisi', [RekapAplikasiController::class, 'submitRevisi'])
         ->name('assessment.revisi.submit');
});
//
// end

// ============================================================
// bagian ini untuk melihat daftar pengajuan assessment
// ============================================================
//
// start
Route::get('/opd.daftar-pengajuan-assessment', [\App\Http\Controllers\OpdController::class, 'daftarPengajuan'])
    ->name('opd.daftar-pengajuan-assessment')
    ->middleware([]);
//
//end

// ============================================================
// bagian ini untuk edit akun pribadi -> template laravel blade
// ============================================================
//
// start
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//
//end

// ============================================================
// Mulai ke bawah untuk CRUD
// ============================================================
// - admin
// - opd
// ============================================================
//
// start
//
// ============================================================
// Untuk Role Admin
// ============================================================
//
Route::resource('/rekap-aplikasi', RekapAplikasiController::class);

// Route untuk list aplikasi
Route::get('/admin/list-apk', [RekapAplikasiController::class, 'index'])->name('admin.list-apk');

// Route untuk form tambah aplikasi
Route::get('/rekap-aplikasi/create', [RekapAplikasiController::class, 'create'])->name('rekap-aplikasi.create');
Route::post('/rekap-aplikasi', [RekapAplikasiController::class, 'store'])->name('rekap-aplikasi.store');

// Route untuk edit aplikasi
Route::get('/rekap-aplikasi/{id}/edit', [RekapAplikasiController::class, 'edit'])->name('rekap-aplikasi.edit');
Route::put('/rekap-aplikasi/{id}', [RekapAplikasiController::class, 'update'])->name('rekap-aplikasi.update');

// Route untuk menampilkan detail aplikasi
Route::get('/rekap-aplikasi/{id}', [RekapAplikasiController::class, 'show'])->name('rekap-aplikasi.show');

// Route untuk delete aplikasi
Route::delete('/rekap-aplikasi/{id}', [RekapAplikasiController::class, 'destroy'])->name('rekap-aplikasi.destroy');

// Untuk menampilkan rekap aplikasi
Route::get('admin/rekap-aplikasi', [RekapAplikasiController::class, 'index'])->name('rekap-aplikasi.index');

// Verifikasi route dan pastikan file auth.php dimuat
require __DIR__.'/auth.php';

// ============================================================
// Untuk Role OPD
// ============================================================
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

// ============================================================
// Bagian ini untuk fungsi approve pengajuan OPD oleh user
// ============================================================
// - Karena revisi fitur ini tidak digunakan
// ============================================================
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

// ============================================================
// Bagian ini untuk undangan
// ============================================================
//
// Start
Route::resource('rekap-aplikasi', RekapAplikasiController::class);
Route::resource('undangan', UndanganController::class);
//
// end

// ============================================================
// bagian ini untuk mencoba melakukan soft delete
// ============================================================
// - Sotf Delete (hanya ini yang dipakai)
// - Restore
// - permanet delete
// ============================================================
// start
//
// Route to view trashed applications
Route::get('/rekap-aplikasi/trash', [RekapAplikasiController::class, 'trash'])->name('rekap-aplikasi.trash');
//
// Route to restore a trashed application
Route::post('/rekap-aplikasi/{id}/restore', [RekapAplikasiController::class, 'restore'])->name('rekap-aplikasi.restore');
//
// Route to permanently delete a trashed application
Route::delete('/rekap-aplikasi/{id}/force-delete', [RekapAplikasiController::class, 'forceDelete'])->name('rekap-aplikasi.force-delete');
//
// end
