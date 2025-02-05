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
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/kegiatan/dokumentasi/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Edit Dokumentasi Kegiatan</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Dokumentasi Kegiatan</h2>
        <form method="POST" action="{{ route('dokumentasiKegiatan.update', $kegiatan->keg_id) }}" enctype="multipart/form-data">
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
                        <input type="time" name="keg_jam_mulai" id="keg_jam_mulai" class="form-control" value="{{ old('keg_jam_mulai', \Carbon\Carbon::parse($kegiatan->keg_jam_mulai)->format('H:i')) }}" required>
                        @error('keg_jam_mulai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_tempat" class="form-label fw-bold">Tempat</label>
                        <input type="text" name="keg_tempat" id="keg_tempat" class="form-control"  max="{{ date('Y-m-d') }}" value="{{ old('keg_tempat', $kegiatan->keg_tempat) }}" required>
                        @error('keg_tempat')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_tgl_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" name="keg_tgl_selesai" id="keg_tgl_selesai" class="form-control"  max="{{ date('Y-m-d') }}" value="{{ old('keg_tgl_selesai', $kegiatan->keg_tgl_selesai) }}" required>
                        @error('keg_tgl_selesai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_selesai" class="form-label fw-bold">Waktu Selesai</label>
                        <input type="time" name="keg_jam_selesai" id="keg_jam_selesai" class="form-control"value="{{ old('keg_jam_selesai', \Carbon\Carbon::parse($kegiatan->keg_jam_selesai)->format('H:i')) }}" required>
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


            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_link_folder" class="form-label fw-bold">Link Folder Kegiatan</label>
                        <input type="text" name="keg_link_folder" id="keg_link_folder" class="form-control" value="{{ old('keg_link_folder', $kegiatan->keg_link_folder) }}" required>
                        @error('keg_link_folder')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_dok_notulen" class="form-label fw-bold">File Notulensi</label>
                        <input
                        type="file"
                        name="keg_dok_notulen"
                        id="keg_dok_notulen"
                        class="form-control"
                        accept=".pdf,.doc,.docx,.xls,.xlsx">
                        @error('keg_dok_notulen')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <sub>

                            Berkas saat ini:
                            <a
                                href="{{ asset('storage/' . $kegiatan->keg_dok_notulen) }}"
                                className="text-decoration-none"
                                target="_blank"
                                rel="noopener noreferrer">
                                [Unduh Berkas]
                            </a>
                            <br />
                            Unggah ulang jika ingin mengganti berkas yang sudah ada
                        </sub>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_status_dok_notulen" class="form-label fw-bold">Status Dokumen</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="keg_status_dok_notulen" 
                                    id="privat" 
                                    value="Privat" 
                                    {{ old('keg_status_dok_notulen', $kegiatan->keg_status_dok_notulen) == 'Privat' ? 'checked' : '' }} 
                                    required>
                                <label class="form-check-label" for="privat">
                                    Privat
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="keg_status_dok_notulen" 
                                    id="publik" 
                                    value="Publik" 
                                    {{ old('keg_status_dok_notulen', $kegiatan->keg_status_dok_notulen) == 'Publik' ? 'checked' : '' }} 
                                    required>
                                <label class="form-check-label" for="publik">
                                    Publik
                                </label>
                            </div>
                            @error('keg_status_dok_notulen')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="border p-2 text-center" style="min-width: 150px; min-height: 200px;">
                        <!-- Gambar preview -->
                        <img 
                            id="preview" 
                            class="img-fluid img-thumbnail"  
                            src="{{ $kegiatan->keg_foto_sampul ? asset('storage/' . $kegiatan->keg_foto_sampul) : '' }}" 
                            alt="Preview Foto" 
                            style="max-height: 200px; {{ $kegiatan->keg_foto_sampul ? 'display: block;' : 'display: none;' }}">
                        <!-- Teks jika tidak ada foto -->
                        <p id="placeholder" class="text-muted m-0" style="{{ $kegiatan->keg_foto_sampul ? 'display: none;' : 'display: block;' }}">
                            Tidak ada foto yang dipilih
                        </p>
                    </div>
                    <!-- Input file -->
                    <input type="file" name="keg_foto_sampul" id="keg_foto_sampul" class="form-control mt-2" accept="image/*">
                </div>

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

@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imgInp = document.getElementById('keg_foto_sampul');
        const previewImg = document.getElementById('preview');
        const placeholderText = document.getElementById('placeholder');

        // Fungsi untuk memperbarui preview
        const updatePreview = (file) => {
            if (file) {
                previewImg.src = URL.createObjectURL(file);
                previewImg.style.display = 'block';
                placeholderText.style.display = 'none';
            } else {
                previewImg.style.display = 'none';
                placeholderText.style.display = 'block';
            }
        };

        // Event listener untuk perubahan input file
        imgInp.addEventListener('change', () => {
            const files = imgInp.files;
            if (files && files[0]) {
                updatePreview(files[0]); // Tampilkan gambar baru
            }
        });


        @if(session('error'))
        Swal.fire({
            title: 'Gagal!',
            text: @json(session('error')),
            icon: 'error',
            confirmButtonText: 'Tutup'
        });
        @endif

        @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: @json(session('success')),
            icon: 'success',
            confirmButtonText: 'Tutup'
        });
        @endif

        CKEDITOR.replace('keg_deskripsi', {
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList']
                },
                {
                    name: 'links',
                    items: ['Link']
                }
            ]
        });
       
        
    });




</script>

@endsection
@endsection

