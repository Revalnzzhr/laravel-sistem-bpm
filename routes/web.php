<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KegiatanController;

Route::get('/', function () {
    return view('layouts.app');
});


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
