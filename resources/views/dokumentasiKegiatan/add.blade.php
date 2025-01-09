@extends('layouts.app')

@section('content')
<style>
    .preview-image {
        max-width: 100%;
        margin-top: 10px;
        display: none;
    }

    input[readonly] {
        background-color: #e9ecef; /* Latar abu-abu */
        color: #6c757d; /* Warna teks */
        cursor: not-allowed; /* Gaya kursor */
    }
</style>
<div class="d-flex flex-column min-vh-100 p-5 pt-0">
    <div class="ms-5 ps-3">
        <div style="display: flex; align-items: center;">
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/kegiatan/dokumentasi/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Kelola Dokumentasi Kegiatan</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Dokumentasi Kegiatan</h2>
        <form id="saveForm" method="POST" action="{{ route('dokumentasiKegiatan.store', ['id' => $kegiatan->first()->keg_id ?? '']) }}" enctype="multipart/form-data">
            @csrf

            
            <div class="form-group mb-3">
                        <label for="keg_id" class="form-label fw-bold">Jadwal Kegiatan</label>
                        <select name="keg_id" id="keg_id" class="form-control" onchange="fetchKegiatanDetails(this.value)" required>
                            <option value="">-- Pilih Jadwal Kegiatan --</option>
                            @foreach ($kegiatan as $jadwal)
                                <option value="{{ $jadwal->keg_id }}" {{ old('keg_id') == $jadwal->keg_id ? 'selected' : '' }}>
                                    {{ $jadwal->keg_nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('keg_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
           

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="jkg_id" class="form-label fw-bold">Jenis Kegiatan</label>
                        <input type="text" name="jkg_id" id="jkg_id" class="form-control" value="{{ old('jkg_id') }}" readonly>
                        @error('jkg_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_tgl_mulai" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" name="keg_tgl_mulai" id="keg_tgl_mulai" class="form-control" value="{{ old('keg_tgl_mulai') }}" readonly>
                        @error('keg_tgl_mulai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_mulai" class="form-label fw-bold">Waktu Mulai</label>
                        <input type="time" name="keg_jam_mulai" id="keg_jam_mulai" class="form-control" value="{{ old('keg_jam_mulai') }}" readonly>
                        @error('keg_jam_mulai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_tempat" class="form-label fw-bold">Tempat</label>
                        <input type="text" name="keg_tempat" id="keg_tempat" class="form-control" value="{{ old('keg_tempat') }}" readonly>
                        @error('keg_tempat')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_tgl_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                        <input type="date" name="keg_tgl_selesai" id="keg_tgl_selesai" class="form-control" value="{{ old('keg_tgl_selesai') }}" readonly>
                        @error('keg_tgl_selesai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="keg_jam_selesai" class="form-label fw-bold">Waktu Selesai</label>
                        <input type="time" name="keg_jam_selesai" id="keg_jam_selesai" class="form-control" value="{{ old('keg_jam_selesai') }}" readonly>
                        @error('keg_jam_selesai')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="keg_deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="keg_deskripsi" id="keg_deskripsi" class="form-control" rows="5" value="{{ old('keg_deskripsi') }}" readonly></textarea>
                @error('keg_deskripsi')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="keg_link_folder" class="form-label fw-bold">Link Folder Kegiatan</label>
                        <input type="text" name="keg_link_folder" id="keg_link_folder" class="form-control" value="{{ old('keg_link_folder') }}" required>
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
                    </div>

                    <div class="form-group mb-3">
                        <label for="keg_status_dok_notulen" class="form-label fw-bold">Status Dokumen</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="keg_status_dok_notulen" id="privat" value="Privat" 
                                    {{ old('keg_status_dok_notulen') == 'Privat' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="privat">
                                    Privat
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="keg_status_dok_notulen" id="publik" value="Publik" 
                                    {{ old('keg_status_dok_notulen') == 'Publik' ? 'checked' : '' }} required>
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
                    <label for="keg_foto_sampul" class="form-label fw-bold">Foto Sampul</label>
                    <div class="border p-2 text-center" style="min-width: 150px; min-height: 200px;">
                        <!-- Gambar preview -->
                        <img id="preview" class="img-fluid img-thumbnail" alt="Preview Foto" style="max-height: 200px; display: none;">
                        <!-- Teks jika tidak ada foto -->
                        <p id="placeholder" class="text-muted m-0">Tidak ada foto yang dipilih</p>
                    </div>
                    <!-- Input file -->
                    <input type="file" name="keg_foto_sampul" id="keg_foto_sampul" class="form-control mt-2" accept="image/*">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <button type="submit" class="btn btn-primary w-100">Simpan</button>
                </div>
                <div class="col-lg-6">
                    <a href="{{ route('berita.read') }}" class="btn btn-danger w-100">Batal</a>
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
        const kegiatanDropdown = document.getElementById('keg_id');
        if (!kegiatanDropdown || kegiatanDropdown.options.length <= 1) {
            Swal.fire({
                title: 'Tidak Ada Jadwal Kegiatan',
                text: 'Tidak ada jadwal kegiatan yang tersedia untuk dokumentasi.',
                icon: 'warning',
                confirmButtonText: 'Kembali'
            }).then(() => {
                window.location.href = '/kegiatan/dokumentasi/read'; // Sesuaikan URL ini jika diperlukan
            });
        }

        const imgInp = document.getElementById('keg_foto_sampul');
        const previewImg = document.getElementById('preview');
        const placeholderText = document.getElementById('placeholder');

        imgInp.addEventListener('change', (evt) => {
            const files = imgInp.files;  // Get the FileList
            if (files && files[0]) {  // Check if there is at least one file selected
                previewImg.src = URL.createObjectURL(files[0]);  // Use the first file from the FileList
                previewImg.style.display = 'block';              // Show the image element
                placeholderText.style.display = 'none';          // Hide the placeholder text
            } else {
                previewImg.style.display = 'none';               // Hide the image element
                placeholderText.style.display = 'block';         // Show the placeholder text
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


    function fetchKegiatanDetails(kegId) {
        const form = document.getElementById('saveForm');
    if (kegId) {
        fetch(`/kegiatan/dokumentasi/${kegId}`)
            .then(response => response.json())
            .then(data => {
                // Mengisi nilai field lainnya
                document.getElementById('keg_tgl_mulai').value = data.keg_tgl_mulai || '';
                document.getElementById('keg_jam_mulai').value = data.keg_jam_mulai || '';
                document.getElementById('keg_tempat').value = data.keg_tempat || '';
                document.getElementById('keg_tgl_selesai').value = data.keg_tgl_selesai || '';
                document.getElementById('keg_jam_selesai').value = data.keg_jam_selesai || '';
                document.getElementById('jkg_id').value = data.jkg_nama || '';

                if (CKEDITOR.instances.keg_deskripsi) {
                    CKEDITOR.instances.keg_deskripsi.setData(data.keg_deskripsi || '');
                }

                form.action = `{{ url('/kegiatan/dokumentasi/save') }}/${kegId}`;
            })
            .catch(error => {
                console.error('Error fetching kegiatan details:', error);
            });
    } else {
        // Kosongkan field jika tidak ada kegiatan yang dipilih
        document.getElementById('keg_tgl_mulai').value = '';
        document.getElementById('keg_jam_mulai').value = '';
        document.getElementById('keg_tempat').value = '';
        document.getElementById('keg_tgl_selesai').value = '';
        document.getElementById('keg_jam_selesai').value = '';
        document.getElementById('jkg_id').value = '';
        
        // Kosongkan CKEditor
        if (CKEDITOR.instances.keg_deskripsi) {
            CKEDITOR.instances.keg_deskripsi.setData('');
        }
    }


}

</script>

@endsection
@endsection