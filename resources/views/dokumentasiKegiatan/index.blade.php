@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

<div class="container mt-4 mb-5">
    <div class="text-center mb-4">
        <h2 style="color:#2654A1; font-size: 1.8rem; font-weight: 700;">
            Dokumentasi Kegiatan <br /> Badan Penjamin Mutu (BPM)
        </h2>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="{{ route('dokumentasiKegiatan.read') }}">Kelola Dokumentasi Kegiatan</a>
    </div>

    <!-- Tabs for Jenis Kegiatan -->
    <ul class="nav nav-tabs mb-3" id="jenisKegiatanTabs" role="tablist">
        @foreach($jenisKegiatan as $jenis)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($loop->first) active @endif" id="tab-{{ $jenis->jkg_id }}" data-bs-toggle="tab" data-bs-target="#content-{{ $jenis->jkg_id }}" type="button" role="tab" aria-controls="content-{{ $jenis->jkg_id }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $jenis->jkg_nama }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="jenisKegiatanContent">
        @foreach($jenisKegiatan as $jenis)
        <div class="tab-pane fade @if($loop->first) show active @endif" id="content-{{ $jenis->jkg_id }}" role="tabpanel" aria-labelledby="tab-{{ $jenis->jkg_id }}">
            @php
                // Filter kegiatan berdasarkan jenis kegiatan ID
                $filteredKegiatan = $kegiatan->where('jkg_id', $jenis->jkg_id);

                // Group kegiatan berdasarkan tahun
                $kegiatanPerTahun = $filteredKegiatan->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->keg_tgl_mulai)->format('Y');
                });
            @endphp

            <!-- Jika tidak ada kegiatan -->
            @if($filteredKegiatan->isEmpty())
                <p class="text-center mt-3">Data tidak ada</p>
            @else
                <div class="accordion" id="accordion-{{ $jenis->jkg_id }}">
                    @foreach($kegiatanPerTahun as $tahun => $kegiatanList)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-{{ $jenis->jkg_id }}-{{ $tahun }}">
                            <button class="accordion-button @if(!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $jenis->jkg_id }}-{{ $tahun }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ $jenis->jkg_id }}-{{ $tahun }}">
                                {{ $tahun }}
                            </button>
                        </h2>
                        <div id="collapse-{{ $jenis->jkg_id }}-{{ $tahun }}" class="accordion-collapse collapse @if($loop->first) show @endif" aria-labelledby="heading-{{ $jenis->jkg_id }}-{{ $tahun }}" data-bs-parent="#accordion-{{ $jenis->jkg_id }}">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach($kegiatanList as $kegiatanItem)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $kegiatanItem->keg_foto_sampul) }}" class="card-img-top" alt="{{ $kegiatanItem->keg_nama }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $kegiatanItem->keg_nama }}</h5>
                                                <p class="card-text">
                                                    <strong>{{ \Carbon\Carbon::parse($kegiatanItem->keg_tgl_mulai)->format('l, d F Y') }}</strong><br>
                                                    {{ \Carbon\Carbon::parse($kegiatanItem->keg_jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($kegiatanItem->keg_jam_selesai)->format('H:i') }} WIB<br>
                                                    <strong>Tempat:</strong> {{ $kegiatanItem->keg_tempat }}
                                                </p>
                                                <a href="{{ $kegiatanItem->keg_link_folder }}" class="btn btn-primary btn-sm" target="_blank">Galeri Selengkapnya</a>
                                                @if($kegiatanItem->keg_status_dok_notulen === 'ada')
                                                <a href="{{ asset('storage/' . $kegiatanItem->keg_dok_notulen) }}" class="btn btn-danger btn-sm" target="_blank">File Notulen</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
@endsection
