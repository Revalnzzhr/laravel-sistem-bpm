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
        <h2 class="mb-5" style="color: #5F5858; text-align: center;">Detail Berita</h2>
        <div class="form-group mb-3">
            <label for="ber_judul" class="form-label fw-bold">Judul Berita</label>
            <p>{{ $berita->ber_judul }}</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="ber_tgl" class="form-label fw-bold">Tanggal Berita</label>
                    <p>{{ \Carbon\Carbon::parse($berita->ber_tgl)->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="ber_penulis" class="form-label fw-bold">Penulis</label>
                    <p>{{ $berita->ber_penulis }}</p>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="ber_isi" class="form-label fw-bold">Isi Berita</label>
            <p>{!! $berita->ber_isi !!}</p>
        </div>

        <div class="row">
            @foreach (range(1, 3) as $index)
            <div class="col-lg-4 col-md-6 mb-4">
                <label for="ber_foto{{ $index }}" class="form-label fw-bold">Foto {{ $index }}</label>
                <div class="border p-2 text-center" style="min-width: 150px; min-height: 200px;">
                    @if($berita["ber_foto$index"])
                    <img src="{{ asset('storage/' . $berita["ber_foto$index"]) }}" class="img-fluid img-thumbnail" alt="Foto {{ $index }}" style="max-height: 200px;">
                    @else
                    <p class="text-muted m-0">Tidak ada foto yang tersedia</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6">
                <label class="form-label fw-bold">Dibuat oleh</label>
                <p> {{ $berita->ber_created_by }} </p>
                <label class="form-label fw-bold">Dibuat pada</label>
                <p>
                    {{ \Carbon\Carbon::parse($berita->ber_created_date)->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
            <div class="col-lg-6 col-md-6">
                <label class="form-label fw-bold">Diubah oleh</label>
                <p> {{ $berita->ber_modif_by }} </p>
                <label class="form-label fw-bold">Diubah pada</label>
                <p>
                    {{ \Carbon\Carbon::parse($berita->ber_modif_date)->locale('id')->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>

    </div>
</div>

@section('scripts')
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
@endsection
@endsection