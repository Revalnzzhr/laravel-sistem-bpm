@extends('layouts.app')

@section('content')
<style>
    .latarGradasi {
        background: linear-gradient(to bottom, #2654A1, #4989C2, #42ABDC);
        /* Gradient colors */
        height: 95vh;
        width: 100%;
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .card {
        padding: 50px;
        /* Optional padding for spacing */
        background: lightgray;
        border-radius: 20px;
        display: inline-block;
        /* Ensures it only takes up as much space as needed */
        border-color: #5CC7AF;
        width: 100%;
    }

    .latarGradasi2 {
        background: linear-gradient(to top, #2654A1, #2654A1, #4989C2, #42ABDC);
        /* Gradasi warna */
        height: 100%;
        /* Atur tinggi latar sesuai kebutuhan, contoh ini 40% tinggi layar */
        width: 100%;
        /* 100% lebar layar */
        display: flex;
        /* Agar konten bisa diatur menggunakan flexbox */
        justify-content: center;
        /* Memposisikan konten horizontal di tengah */
        position: relative;
        overflow: hidden;
        /* Menghindari elemen keluar dari batas latar */
    }
</style>
<div class="latarGradasi mt-0">
    <div class="position-absolute top-0 end-0 p-5 mb-3" style="z-index: 20;">

        <a class="btn btn-primary" href="{{ route('tentang.read') }}">Kelola Tentang</a>
    </div>

    <img src="{{ asset('storage/assets/bangunan.png') }}" alt="Bangunan" style="position: absolute; bottom: 0; width: 100%; left: 0; z-index: 1;">

    <img src="{{ asset('storage/assets/orang.png') }}" alt="Orang" style="position: absolute; bottom: -2rem; left: 50%; transform: translateX(-50%); width: 33vw; z-index: 2;">

    <div class="d-flex flex-column align-items-center justify-content-start" style="position: relative; z-index: 3; margin: 1rem; padding: 2rem; min-height: 100vh; width: 800px;">
        <img src="{{ asset('storage/bpm-logo.png') }}" alt="Logo" style="width: 200px; height: auto; margin-bottom: 25px;">

        @if(isset($tentangs[0]))
        <p class="text-center text-white" style="font-size: 18px; text-align: center; margin: 0 auto; width: 100%;">{{ $tentangs[0]['ten_isi'] }}</p>
        @endif


    </div>
</div>

<div class="shadow bg-white rounded" style="padding: 5rem; margin: 8rem;">
    <h2 style="color: #2654A1; font-weight: 700; text-align: left;">Sejarah BPM</h2>

    <div class="row align-items-center">
        <div class="col-lg-4 col-md-6">
            <img src="{{ asset('storage/assets/orang-laptop.png') }}" alt="Orang Laptop" style="width: 80%; height: auto; margin-bottom: 25px;">
        </div>
        <div class="col-lg-8 col-md-6">
            @if(isset($tentangs[1]))
            <p style="text-align: justify; font-size: 16px; color: grey;">{!! $tentangs[1]['ten_isi'] !!}</p>
            @endif
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-lg-6 col-md-6">
            <div class="shadow p-4 mt-5 bg-white rounded">
                <h2 style="color: #2654A1; font-weight: 700; text-align: left;">SK Pendirian BPM</h2>
                <p style="text-align: left; font-size: 16px; color: grey;">SK Pendirian BPM dapat diakses dengan mengklik kolom dibawah ini:</p>
                <a href="{{ url('path/to/file') }}" class="btn btn-primary" target="_blank">Unduh SK Pendirian</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <img src="{{ asset('storage/assets/orang-kerja.png') }}" alt="Orang Kerja" style="width: 100%; height: auto; margin-bottom: 25px;">
        </div>
    </div>


    <div class="shadow bg-white rounded-4 mb-4">
        <div class="rounded-4 p-3" style="background-color: #2654A1; ">
            <!-- HeaderText -->
            <h2 style="color: white; font-size: 1.5rem; font-weight: 600; text-align: left;">
                <?= htmlspecialchars($tentangs[8]['ten_category']); ?>
            </h2>
        </div>
        <div class="rounded-4 p-3">
            <?php if (!empty($tentangs[8]['ten_category'])) { ?>
                <!-- Text -->
                <p style="text-align: justify; font-size: 16px; color: grey;">
                    {!! $tentangs[8]['ten_isi'] !!}
                </p>
            <?php } ?>
        </div>
    </div>
    <div class="shadow bg-white rounded-4 mb-4">
        <div class="rounded-4 p-3" style="background-color: #2654A1; ">
            <!-- HeaderText -->
            <h2 style="color: white; font-size: 1.5rem; font-weight: 600; text-align: left;">
                <?= htmlspecialchars($tentangs[9]['ten_category']); ?>
            </h2>
        </div>
        <div class="rounded-4 p-3">
            <?php if (!empty($tentangs[9]['ten_category'])) { ?>
                <!-- Text -->
                <p style="text-align: justify; font-size: 16px; color: grey;">
                    {!! $tentangs[9]['ten_isi'] !!}
                </p>
            <?php } ?>
        </div>
    </div>
</div>

<div class="flex-grow-1" style="background-color: #193756; padding: 4rem;">
    <div class="row">

        <div class="col-lg-6 col-md-6 mb-3" style="padding: 2rem;">
            <div class="card" style="padding-left: 3rem; padding: 3rem;">
                <!-- HeaderText -->
                <h2 style="color: #2654A1; text-align: center; font-size: 25px; font-weight: 700;">
                    {!! $tentangs[2]['ten_category'] !!}
                </h2>

                <?php if (!empty($tentangs[2]['ten_isi'])): ?>
                    <!-- Text -->
                    <p style="text-align: justify; font-size: 16px; color: white;">
                        {!! $tentangs[2]['ten_isi'] !!}
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 mb-3" style="padding: 2rem;">
            <div class="card" style="padding-left: 3rem; padding: 3rem;">
                <!-- HeaderText -->
                <h2 style="color: #2654A1; text-align: center; font-size: 25px; font-weight: 700;">
                    {!! $tentangs[3]['ten_category'] !!}
                </h2>

                <?php if (!empty($tentangs[3]['ten_isi'])): ?>
                    <!-- Text -->
                    <p style="text-align: justify; font-size: 16px; color: white !important;">
                        {!! $tentangs[3]['ten_isi'] !!}
                    </p>

                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<div class="flex-grow-1 p-5" style="background-color: white;">
    <h2 style="color: #2654A1; font-weight: 700; text-align: center; margin-bottom: 50px;">Struktur BPM</h2>
    <img src="{{ asset('storage/tentang/' . $tentangs[6]['ten_isi']) }}" alt="Struktur BPM" style="width: 100%; height: auto;">
</div>

<div class="latarGradasi2">
    <div
        class="d-flex flex-column align-items-center justify-content-start m-5 p-3"
        style="min-height: 100vh; width: 800px;">
        <img src="{{ asset('storage/bpm-logo.png') }}" alt="Logo" style="width: 200px; height: auto; margin-bottom: 25px;">


        <!-- Visi dan Misi -->

        <div>
            <!-- HeaderText -->
            <h2 style="color: white; text-align: center; font-size: 35px; font-weight: 700;">
                {!! $tentangs[4]['ten_category'] !!}
            </h2>

            <!-- Text -->
            <?php if (!empty($tentangs[4]['ten_isi'])): ?>
                <p style="text-align: center; font-size: 1rem;">
                    {!! $tentangs[4]['ten_isi'] !!}
                </p>
            <?php endif; ?>
        </div>

        <div>
            <!-- HeaderText -->
            <h2 style="color: white; text-align: center; font-size: 35px; font-weight: 700;">
                {!! $tentangs[5]['ten_category'] !!}
            </h2>

            <!-- Text -->
            <?php if (!empty($tentangs[5]['ten_isi'])): ?>
                <p style="text-align: center; font-size: 1rem;">
                    {!! $tentangs[5]['ten_isi'] !!}
                </p>
            <?php endif; ?>
        </div>


        <!-- Images -->
        <img
            src="{{ asset('storage/assets/gedung-astra.png') }}"
            alt="Bangunan"
            style="position: absolute; width: 100%; height: auto; bottom: 0px;" />
        <img
            src="{{ asset('storage/assets/mahasiswa.png') }}"
            alt="Orang"
            style="position: relative; width: 150%; height: auto; bottom: -70px;" />
    </div>
</div>



@endsection