@extends('layouts.app')

@section('content')
<style>

</style>
<div class="d-flex flex-column min-vh-100 p-5 pt-0">
    <div class="ms-5 ps-3">
        <div style="display: flex; align-items: center; ">
            <span style="color: #2654A1; font-size: 5rem; margin-right: 10px; cursor: pointer;" onclick="window.location.href='/tentang/read'">&#x2039;</span>
            <h2 style="color: #2654A1; margin: 0; padding-top:1rem;">Kelola Tentang</h2>
        </div>
    </div>

    <div class="shadow p-5 m-5 mt-3 bg-white rounded">
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Formulir Tentang</h2>
        <form action="{{ route('tentang.update', $tentang->id) }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group mb-3">
                <label for="ten_category" class="form-label fw-bold">Kategori</label>
                <p> {{ $tentang->ten_category }} </p>
            </div>

            <div class="form-group mb-3">
                <label for="ten_isi" class="form-label fw-bold">Isi</label>
                <?php if ($tentang->id == 7): ?>
                    <div class="preview-container">
                        <img
                            id="blah"
                            class="preview-image"
                            src="<?= !empty($tentang->ten_isi) ? asset('storage/tentang/' . $tentang->ten_isi) : '' ?>"
                            alt="Preview Image"
                            style="max-width: 100%; margin-top: 10px; <?= !empty($tentang->ten_isi) ? 'display: block;' : 'display: none;' ?>">
                        <p class="preview-text" style="<?= !empty($tentang->ten_isi) ? 'display: none;' : 'display: block;' ?>">Your image preview will appear here.</p>
                    </div>

                <?php elseif ($tentang->id == 8): ?>
                    <br />
                    <a
                        href="{{ asset('storage/tentang/' . $tentang->ten_isi) }}"
                        className="text-decoration-none"
                        target="_blank"
                        rel="noopener noreferrer">
                        Lihat Pratinjau
                    </a>

                <?php else: ?>
                    <p>{!! $tentang->ten_isi !!}</p>
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-bold">Dibuat oleh</label>
                    <p> {{ $tentang->ten_created_by }} </p>
                    <label class="form-label fw-bold">Dibuat pada</label>
                    <p>
                        {{ \Carbon\Carbon::parse($tentang->ten_created_date)->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-bold">Diubah oleh</label>
                    <p> {{ $tentang->ten_modif_by }} </p>
                    <label class="form-label fw-bold">Diubah pada</label>
                    <p>
                        {{ \Carbon\Carbon::parse($tentang->ten_modif_date)->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

        </form>
    </div>

</div>

@section('scripts')
<!-- Menyertakan CKEditor 4 CDN -->
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>

</script>
@endsection
@endsection