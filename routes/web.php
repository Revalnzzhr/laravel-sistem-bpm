<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('beranda.index');
});



Route::get('/login', function () {
    return view('login.index');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');



Route::get('/tentang', [TentangController::class, 'index'])->name('tentang.index');
Route::get('/tentang/read', [TentangController::class, 'read'])->name('tentang.read');
Route::get('/tentang/edit/{id}', [TentangController::class, 'edit'])->name('tentang.edit');
Route::post('tentang/update/{id}', [TentangController::class, 'update'])->name('tentang.update');
Route::get('/tentang/show/{id}', [TentangController::class, 'show'])->name('tentang.show');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/read', [BeritaController::class, 'read'])->name('berita.read');
Route::get('/berita/add', [BeritaController::class, 'add'])->name('berita.add');
Route::post('/berita/save', [BeritaController::class, 'save'])->name('berita.save');
Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
Route::post('berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
Route::get('/berita/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::delete('/berita/{id}/delete', [BeritaController::class, 'delete'])->name('berita.delete');
Route::get('/berita/search', [BeritaController::class, 'search'])->name('berita.search');
Route::get('/berita/searchRead', [BeritaController::class, 'searchRead'])->name('berita.searchRead');
Route::get('/berita/bacaBerita/{id}', [BeritaController::class, 'see'])->name('berita.see');


Route::get('/kegiatan/jadwal', [KegiatanController::class, 'indexJadwal'])->name('jadwalKegiatan.index');
Route::get('/kegiatan/jadwal/read', [KegiatanController::class, 'readJadwal'])->name('jadwalKegiatan.read');
Route::get('/kegiatan/jadwal/add', [KegiatanController::class, 'addJadwal'])->name('jadwalKegiatan.add');
Route::post('/kegiatan/jadwal/save', [KegiatanController::class, 'storeJadwal'])->name('jadwalKegiatan.store');
Route::get('/kegiatan/jadwal/edit/{id}', [KegiatanController::class, 'editJadwal'])->name('jadwalKegiatan.edit');
Route::put('/kegiatan/jadwal/update/{id}', [KegiatanController::class, 'updateJadwal'])->name('jadwalKegiatan.update');
Route::get('/kegiatan/jadwal/show/{id}', [KegiatanController::class, 'showJadwal'])->name('jadwalKegiatan.show');
Route::delete('/kegiatan/jadwal/{id}/delete', [KegiatanController::class, 'deleteJadwal'])->name('jadwalKegiatan.delete');
Route::get('/kegiatan/jadwal/search', [KegiatanController::class, 'searchJadwal'])->name('jadwalKegiatan.search');


Route::get('/kegiatan/dokumentasi', [KegiatanController::class, 'indexDokum'])->name('dokumentasiKegiatan.index');
Route::get('/kegiatan/dokumentasi/read', [KegiatanController::class, 'readDokum'])->name('dokumentasiKegiatan.read');
Route::get('/kegiatan/dokumentasi/add', [KegiatanController::class, 'addDokum'])->name('dokumentasiKegiatan.add');
Route::get('/kegiatan/dokumentasi/{id}', [KegiatanController::class, 'getKegiatanDetails']);
Route::post('/kegiatan/dokumentasi/save/{id}', [KegiatanController::class, 'storeDokum'])->name('dokumentasiKegiatan.store');
Route::get('/kegiatan/dokumentasi/edit/{id}', [KegiatanController::class, 'editDokum'])->name('dokumentasiKegiatan.edit');
Route::put('/kegiatan/dokumentasi/update/{id}', [KegiatanController::class, 'updateDokum'])->name('dokumentasiKegiatan.update');
Route::get('/kegiatan/dokumentasi/show/{id}', [KegiatanController::class, 'showDokum'])->name('dokumentasiKegiatan.show');
Route::delete('/kegiatan/dokumentasi/{id}/delete', [KegiatanController::class, 'deleteDokum'])->name('dokumentasiKegiatan.delete');
Route::get('/kegiatan/dokumentasi/search', [KegiatanController::class, 'searchDokum'])->name('dokumentasiKegiatan.search');

Route::get('/peraturan/{type}', [PeraturanController::class, 'index'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.index');

Route::get('/peraturan/{type}/create', function ($type) {
    return view('peraturan.add', ['type' => $type]);
})->where('type', 'kebijakan|eksternal|instrument')->name('peraturan.create');
Route::get('/peraturan/{type}/{id}/show', [PeraturanController::class, 'show'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.show');
Route::get('/peraturan/{type}/{id}/edit', [PeraturanController::class, 'edit'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.edit');
Route::post('/peraturan/store', [PeraturanController::class, 'store'])->name('peraturan.store');
Route::put('/peraturan/{type}/{id}', [PeraturanController::class, 'update'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.update');
Route::get('/peraturan/{type}/{id}/download', [PeraturanController::class, 'download'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.download');
Route::put('/peraturan/{type}/{id}/toggle', [PeraturanController::class, 'toggleStatus'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.toggle');
Route::get('/peraturan/{type}/{id}/upload', [PeraturanController::class, 'showUploadForm'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.upload');

Route::put('/peraturan/{type}/{id}/update-file', [PeraturanController::class, 'updateUnggah'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.updateFile');
Route::get('/peraturan/{type}/{id}/history', [PeraturanController::class, 'showHistory'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.history');
Route::get('/peraturan/{type}/{id}/history-download', [PeraturanController::class, 'showHistoryDownload'])
    ->where('type', 'kebijakan|eksternal|instrument')
    ->name('peraturan.historyDownload');