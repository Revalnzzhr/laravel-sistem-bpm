@extends('layouts.app')

@section('content')
<style>
    .preview-image {
        max-width: 100%;
        margin-top: 10px;
        display: none;
    }
</style>
<div class="d-flex flex-column min-vh-100 p-0">
    <div class="position-relative">
        <div
            id="carouselExample"
            class="carousel slide"
            data-bs-ride="carousel">


            <div class="carousel-inner" style="height: 600px;">
                @if($berita->ber_foto1)
                <div class="carousel-item active" style="background-image: url('{{ asset('storage/'.$berita->ber_foto1) }}'); background-size: cover; background-position: center; height: 600px;">
                    <div
                        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent 40%, transparent 70%, rgba(0, 0, 0, 0.9));"></div>
                </div>
                @endif

                @if($berita->ber_foto2)
                <div class="carousel-item {{ !$berita->ber_foto1 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$berita->ber_foto2) }}'); background-size: cover; background-position: center; height: 600px;">
                    <div
                        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent 40%, transparent 70%, rgba(0, 0, 0, 0.9));"></div>
                </div>
                @endif

                @if($berita->ber_foto3)
                <div class="carousel-item {{ !$berita->ber_foto1 && !$berita->ber_foto2 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/'.$berita->ber_foto3) }}'); background-size: cover; background-position: center; height: 600px;">
                    <div
                        style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), transparent 40%, transparent 70%, rgba(0, 0, 0, 0.9));"></div>
                </div>
                @endif
            </div>

            @if($berita->ber_foto1 || $berita->ber_foto2 || $berita->ber_foto3)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif


            <div class="position-absolute top-0 start-0 m-4" style="padding-left: 10rem; padding-right: 8rem; z-index: 1050;">
                <div style="display: flex; align-items: center;">
                    <span
                        style="color: white; font-size: 5rem; margin-right: 10px; cursor: pointer; z-index: 2000;"
                        onclick="window.location.href='/berita'">
                        &#x2039;
                    </span>
                    <h2 style="color: white; margin: 0; padding-top: 1rem;">Baca Berita</h2>
                </div>
            </div>


            <div class="position-absolute bottom-0 start-0 m-4" style="padding-left: 9rem; padding-right: 8rem;">
                <h2 style="color: white; font-weight:700">{{ $berita->ber_judul }} </h2>
                <p class="text-white">
                    Oleh {{ $berita->ber_penulis }} Tanggal {{ \Carbon\Carbon::parse($berita->ber_tgl)->format('d M Y') ?? 'Tanggal Tidak Tersedia' }}
                </p>
            </div>
        </div>
    </div>

    <div style="padding-left: 7rem; padding-right: 8rem;">
        <div class="bg-white rounded-3" style="padding: 0rem; margin: 3rem;">
            <p>{!! $berita->ber_isi !!} </p>
        </div>
    </div>
</div>
@endsection