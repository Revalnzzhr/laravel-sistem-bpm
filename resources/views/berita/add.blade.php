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
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/berita/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Kelola Berita</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Berita</h2>
        <form method="POST" action="{{ route('berita.save') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="ber_judul" class="form-label fw-bold">Judul Berita</label>
                <input type="text" name="ber_judul" id="ber_judul" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="ber_tgl" class="form-label fw-bold">Tanggal Berita</label>
                        <input type="date" name="ber_tgl" id="ber_tgl" class="form-control" required>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mb-3">
                        <label for="ber_penulis" class="form-label fw-bold">Penulis</label>
                        <input type="text" name="ber_penulis" id="ber_penulis" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="ber_isi" class="form-label fw-bold">Isi Berita</label>
                <textarea name="ber_isi" id="ber_isi" class="form-control" rows="5"></textarea>
            </div>

            <div class="row">
                @foreach (range(1, 3) as $index)
                <div class="col-lg-4 col-md-6 mb-4">
                    <label for="ber_foto{{ $index }}" class="form-label fw-bold">Foto {{ $index }}</label>
                    <div class="border p-2 text-center" style="min-width: 150px; min-height: 200px;">
                        <!-- Gambar preview -->
                        <img id="preview{{ $index }}" class="img-fluid img-thumbnail" alt="Preview Foto {{ $index }}" style="max-height: 200px; display: none;">
                        <!-- Teks jika tidak ada foto -->
                        <p id="placeholder{{ $index }}" class="text-muted m-0">Tidak ada foto yang dipilih</p>
                    </div>
                    <!-- Input file -->
                    <input type="file" name="ber_foto{{ $index }}" id="ber_foto{{ $index }}" class="form-control mt-2" accept="image/*">
                </div>
                @endforeach
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        CKEDITOR.replace('ber_isi', {
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


        const previewImages = [1, 2, 3].map(index => ({
            input: document.getElementById(`ber_foto${index}`),
            preview: document.getElementById(`preview${index}`),
            placeholder: document.getElementById(`placeholder${index}`) // Perbaikan interpolasi string
        }));

        previewImages.forEach(({
            input,
            preview,
            placeholder
        }) => {
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                } else {
                    preview.style.display = 'none';
                    placeholder.style.display = 'block';
                }
            });
        });


    });
</script>
@endsection
@endsection