@extends('layouts.app')

@section('content')
<style>
    .preview-image {
        max-width: 100%;
        margin-top: 10px;
        display: none;
    }
</style>
<div class="d-flex flex-column min-vh-100 p-5 pt-0">
    <div class="ms-5 ps-3">
        <div style="display: flex; align-items: center;">
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/kegiatan/jadwal/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Detail Jadwal Kegiatan</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Jadwal Kegiatan</h2>
        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="keg_nama" class="form-label fw-bold">Nama Kegiatan</label>
                <p>{{ $kegiatan->keg_nama }}</p>

            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <div class="form-group mb-3">
                            <label for="jkg_id" class="form-label fw-bold">Jenis Kegiatan</label>
                            <p>
                                @php
                                $jenisKegiatanNama = $jenisKegiatan->firstWhere('jkg_id', $kegiatan->jkg_id)->jkg_nama ?? 'Jenis kegiatan tidak ditemukan';
                                @endphp
                                {{ $jenisKegiatanNama }}
                            </p>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_tgl_mulai" class="form-label fw-bold">Tanggal Mulai</label>
                        <p> {{ \Carbon\Carbon::parse($kegiatan->keg_tgl_mulai)->locale('id')->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_mulai" class="form-label fw-bold">Waktu Mulai</label>
                        <p>{{ \Carbon\Carbon::parse($kegiatan->keg_jam_mulai)->format('H:i') }} WIB</p>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_tempat" class="form-label fw-bold">Tempat</label>
                        <p>{{ $kegiatan->keg_tempat }}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_tgl_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                        <p>
                            {{ \Carbon\Carbon::parse($kegiatan->keg_tgl_selesai)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_selesai" class="form-label fw-bold">Waktu Selesai</label>
                        <p>{{ \Carbon\Carbon::parse($kegiatan->keg_jam_selesai)->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="keg_deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                <p> {{ $kegiatan->keg_deskripsi }}</p>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-bold">Dibuat oleh</label>
                    <p> {{ $kegiatan->keg_created_by }} </p>
                    <label class="form-label fw-bold">Dibuat pada</label>
                    <p>
                        {{ \Carbon\Carbon::parse($kegiatan->keg_created_date)->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-bold">Diubah oleh</label>
                    <p> {{ $kegiatan->keg_modif_by }} </p>
                    <label class="form-label fw-bold">Diubah pada</label>
                    <p>
                        {{ \Carbon\Carbon::parse($kegiatan->keg_modif_date)->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection