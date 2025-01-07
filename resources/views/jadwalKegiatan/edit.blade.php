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
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Edit Jadwal Kegiatan</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Jadwal Kegiatan</h2>
        <form method="POST" action="{{ route('jadwalKegiatan.update', $kegiatan->keg_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="keg_nama" class="form-label fw-bold">Nama Kegiatan</label>
                <input type="text" name="keg_nama" id="keg_nama" class="form-control" value="{{ old('keg_nama', $kegiatan->keg_nama) }}" required>
                @error('keg_nama')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="jkg_id" class="form-label fw-bold">Jenis Kegiatan</label>
                        <select name="jkg_id" id="jkg_id" class="form-control" required>
                            <option value="">-- Pilih Jenis Kegiatan --</option>
                            @foreach ($jenisKegiatan as $jenis)
                            <option value="{{ $jenis->jkg_id }}" {{ old('jkg_id', $kegiatan->jkg_id) == $jenis->jkg_id ? 'selected' : '' }}>
                                {{ $jenis->jkg_nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('jkg_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_tgl_mulai" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" name="keg_tgl_mulai" id="keg_tgl_mulai" class="form-control" value="{{ old('keg_tgl_mulai', $kegiatan->keg_tgl_mulai) }}" required>
                        @error('keg_tgl_mulai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_mulai" class="form-label fw-bold">Waktu Mulai</label>
                        <input type="time" name="keg_jam_mulai" id="keg_jam_mulai" class="form-control" value="{{ old('keg_jam_mulai', $kegiatan->keg_jam_mulai) }}" required>
                        @error('keg_jam_mulai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_tempat" class="form-label fw-bold">Tempat</label>
                        <input type="text" name="keg_tempat" id="keg_tempat" class="form-control" value="{{ old('keg_tempat', $kegiatan->keg_tempat) }}" required>
                        @error('keg_tempat')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_tgl_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" name="keg_tgl_selesai" id="keg_tgl_selesai" class="form-control" value="{{ old('keg_tgl_selesai', $kegiatan->keg_tgl_selesai) }}" required>
                        @error('keg_tgl_selesai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_selesai" class="form-label fw-bold">Waktu Selesai</label>
                        <input type="time" name="keg_jam_selesai" id="keg_jam_selesai" class="form-control" value="{{ old('keg_jam_selesai', $kegiatan->keg_jam_selesai) }}" required>
                        @error('keg_jam_selesai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="keg_deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="keg_deskripsi" id="keg_deskripsi" class="form-control" rows="5" required>{{ old('keg_deskripsi', $kegiatan->keg_deskripsi) }}</textarea>
                @error('keg_deskripsi')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary w-100">Perbarui</button>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('jadwalKegiatan.read') }}" class="btn btn-danger w-100">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection