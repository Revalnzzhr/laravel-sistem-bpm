@extends('layouts.app')

@section('content')
<style>
    #preview {
        max-width: 100%;
        margin-top: 10px;
        display: none;
    }
</style>
<div class="d-flex flex-column min-vh-100 p-5 pt-0">
    <div class="ms-5 ps-3">
        <div style="display: flex; align-items: center;">
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/tentang/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Kelola Tentang</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Tentang</h2>
        <form action="{{ route('tentang.update', $tentang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="form-group mb-3">
                <label for="ten_category" class="form-label fw-bold">Kategori</label>
                <input type="text" name="ten_category" id="ten_category" class="form-control" value="{{ old('ten_category', $tentang->ten_category) }}" required>
            </div>

            <div class="form-group">
                <label for="ten_isi" class="form-label fw-bold">Isi</label>
                <?php if ($tentang->id == 7): ?>
                    <div>
                        <!-- Input file untuk gambar -->
                        <input
                            type="file"
                            class="form-control @error('image') is-invalid @enderror"
                            name="ten_isi"
                            accept="image/*"
                            id="imgInp">

                        <!-- Container untuk pratinjau gambar -->
                        <div class="preview-container">
                            <img
                                id="blah"
                                class="preview-image"
                                src="<?= !empty($tentang->ten_isi) ? asset('storage/tentang/' . $tentang->ten_isi) : '' ?>"
                                alt="Preview Image"
                                style="max-width: 100%; margin-top: 10px; <?= !empty($tentang->ten_isi) ? 'display: block;' : 'display: none;' ?>">
                            <p class="preview-text" style="<?= !empty($tentang->ten_isi) ? 'display: none;' : 'display: block;' ?>">Your image preview will appear here.</p>
                        </div>

                        <!-- Menampilkan pesan error jika ada -->
                        @error('ten_isi')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                <?php elseif ($tentang->id == 8): ?>
                    <div>
                    <input
                        type="file"
                        name="ten_isi"
                        id="ten_isi"
                        class="form-control @error('ten_isi') is-invalid @enderror"
                        accept=".pdf">

                    <!-- Pesan error jika format file salah -->
                    <div id="fileError" class="alert alert-danger mt-2" style="display: none;">
                        File harus berupa PDF.
                    </div>

                    <sub>
                        Berkas saat ini:
                        <a
                            href="{{ asset('storage/tentang/' . $tentang->ten_isi) }}"
                            className="text-decoration-none"
                            target="_blank"
                            rel="noopener noreferrer">
                            [Unduh Berkas]
                        </a>
                        <br />
                        Unggah ulang jika ingin mengganti berkas yang sudah ada
                    </sub>
                </div>

                <?php else: ?>
                    <textarea
                        name="ten_isi"
                        id="ten_isi"
                        class="form-control"
                        rows="5"
                        required><?= htmlspecialchars($tentang->ten_isi) ?></textarea>
                <?php endif; ?>
            </div>


            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <button
                        type="submit"
                        class="btn btn-primary mt-3"
                        style="width: 100%;">
                        Update
                    </button>
                </div>
                <div class="col-lg-6 col-md-6">
                    <a
                        href="{{ route('tentang.read') }}"
                        class="btn btn-danger mt-3"
                        style="width: 100%;">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tenIsi = document.getElementById('ten_isi');
        const imgInp = document.getElementById('imgInp');
        const blah = document.getElementById('blah');
        const previewText = document.querySelector('.preview-text');
        const form = document.getElementById('tentangForm');

        const tenIsiInput = document.getElementById('ten_isi');
        const fileError = document.getElementById('fileError');

        if (tenIsiInput) {
            tenIsiInput.addEventListener('change', () => {
                const file = tenIsiInput.files[0];
                
                if (file && tenIsiInput.getAttribute('accept') === '.pdf') {
                    const fileType = file.type;
                    
                    // Validasi format file
                    if (fileType !== 'application/pdf') {
                        fileError.style.display = 'block';
                        tenIsiInput.value = ''; // Kosongkan input jika file tidak valid
                    } else {
                        fileError.style.display = 'none';
                    }
                }
            });
        }


        // Hanya aktifkan CKEditor jika elemen adalah textarea
        if (tenIsi && tenIsi.tagName === 'TEXTAREA') {
            CKEDITOR.replace('ten_isi', {
                toolbar: [{
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline']
                    },
                    {
                        name: 'lists',
                        items: ['NumberedList', 'BulletedList']
                    },
                    {
                        name: 'links',
                        items: ['Link']
                    }
                ]
            });

            form.addEventListener('submit', (e) => {
                // Salin data CKEditor ke dalam textarea sebelum submit
                console.log("jalan")
                tenIsi.value = CKEDITOR.instances.ten_isi.getData();

                // Menambahkan SweetAlert sebelum submit
                e.preventDefault(); // Cegah pengiriman form secara default

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda ingin memperbarui data ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, perbarui!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Jika ya, submit formulir
                    }
                });
            });
        }





        imgInp.addEventListener('change', (evt) => {
            const [file] = imgInp.files;
            if (file) {
                blah.src = URL.createObjectURL(file);
                blah.style.display = 'block';
                previewText.style.display = 'none';
            } else {
                blah.style.display = 'none';
                previewText.style.display = 'block';
            }
        });
    });
</script>
@endsection


@endsection