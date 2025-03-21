<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;

// Halaman Admin
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\Data_siswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalPelajaranController;

// Halaman Guru
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Absen_guruController;
use App\Http\Controllers\Absensiswa_GuruController;

// Halaman Siswa
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\Absen_siswaController;
use App\Http\Controllers\RekapanController;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::resource('mapel', MapelController::class);
    Route::resource('jurusan', JurusanController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('data_siswa', Data_siswaController::class);
    Route::resource('user', UserController::class);
    Route::get('jurusan/{slug}/kelas', [KelasController::class, 'kelasByJurusan'])->name('jurusan.kelas');
});

// Halaman Guru
Route::middleware(['auth', 'role:Guru'])->group(function () {
    Route::resource('guru', GuruController::class);
    Route::get('agenda/create/{kelas_id}', [AgendaController::class, 'create']);
    Route::get('/agenda/{id}/edit', [AgendaController::class, 'edit']);
    Route::put('agenda/{id}', [AgendaController::class, 'update']);
    Route::get('absen_guru/create/{kelas_id}', [Absen_guruController::class, 'create']);
    Route::get('/absen_guru/{id}/edit', [Absen_guruController::class, 'edit']);
    Route::put('absen_guru/{id}', [Absen_guruController::class, 'update']);
    Route::get('absensiswa_guru/create/{kelas_id}', [Absensiswa_GuruController::class, 'create']);
    Route::get('/absensiswa_guru/{id}/edit', [Absensiswa_GuruController::class, 'edit']);
    Route::put('absensiswa_guru/{id}', [Absensiswa_GuruController::class, 'update']);
});

// Halaman Siswa
Route::middleware(['auth', 'role:Sekretaris'])->group(function () {
    Route::resource('siswa', SiswaController::class);
});

Route::middleware(['auth', 'role:Guru,Admin'])->group(function () {
    Route::resource('agenda', AgendaController::class);
    Route::get('agenda/kelas/{slug}', [AgendaController::class, 'agendaByClass']);
    Route::resource('absen_guru', Absen_guruController::class);
    Route::resource('absensiswa_guru', Absensiswa_GuruController::class);
    Route::get('absensiswa_guru/kelas/{slug}', [Absensiswa_GuruController::class, 'absensiswa_guruByClass']);
    Route::get('absensiswa_guru/export/{kelas_slug}', [Absensiswa_GuruController::class, 'exportExcel'])->name('absensiswa_guru.export');
    Route::get('/get-guru/{kelas_id}', [JadwalPelajaranController::class, 'getGuruByKelas']);
    Route::get('/get-mapel/{guru_id}', [JadwalPelajaranController::class, 'getMapelByGuru']);
    Route::get('absensiswa_guru/kelas/{slug}/rekapan', [RekapanController::class, 'rekapanGuru']);
});

Route::middleware(['auth', 'role:Guru,Admin,Sekretaris'])->group(function () {
    Route::get('absen_guru/kelas/{slug}', [Absen_guruController::class, 'absen_guruByClass']);
    Route::resource('absen_siswa', Absen_siswaController::class);
    Route::get('absen_siswa/kelas/{slug}', [Absen_siswaController::class, 'absen_siswaByClass']);
    Route::resource('jadwal_pelajaran', JadwalPelajaranController::class);
    Route::get('absen_siswa/export/{kelas_slug}', [Absen_siswaController::class, 'export'])->name('absen_siswa.export');
    Route::get('absen_siswa/kelas/{slug}/rekapan', [RekapanController::class, 'rekapanSekretaris']);
});

// Login
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::delete('/deleteNotification/{id}', function ($id) {
    $notification = auth()->user()->notifications()->find($id);
    if ($notification) {
        $notification->delete();
    }
    return response()->json(['success' => true]);
});

use App\Http\Controllers\TestNotificationController;

Route::get('/test-notification', [TestNotificationController::class, 'sendTestNotification']);

Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
