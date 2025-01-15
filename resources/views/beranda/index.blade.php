@extends('layouts.app')

@section('content')
<style>
    .latarGradasi {
        background: linear-gradient(to bottom, #2654A1, #4989C2, #42ABDC);
        height: 95vh;
        width: 100%;
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .card {
        padding: 50px;
        background: lightgray;
        border-radius: 20px;
        display: inline-block;
        border-color: #5CC7AF;
        width: 100%;
    }

    .latarGradasi2 {
        background: linear-gradient(to top, #2654A1, #2654A1, #4989C2, #42ABDC);
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
</style>

<div class="latarGradasi" style="position: relative; display: flex; flex-direction: row; align-items: stretch; justify-content: center; min-height: 80vh; z-index: 0; ">
    <img
        src="{{ asset('storage/assets/hiasan3.png') }}"
        style="position: absolute; left: 0rem; bottom: 4rem; z-index: -1; max-width: 30rem; min-width: 83%;"
    />

    <div style="flex: 1; padding: 3rem; display: flex; flex-direction: column; justify-content: center; text-align: left; align-items: flex-start; order: 0;">
        <h1 style="color: white; font-weight: 700; font-size: 3.5rem; margin-top: -3rem;">
            Sejahtera<br />Bersama Bangsa
        </h1>
        <p style="font-size: 1.2rem; color:white;">
            Mendukung revitalisasi pendidikan vokasi di Indonesia dalam penyiapan tenaga kerja kompeten berdaya saing global dan menghasilkan teknologi terapan yang dibutuhkan industri, relevan dan sejalan dengan Astra Untuk Hari Ini dan Masa Depan Indonesia.
        </p>
    </div>

    <div style="flex: 1; position: relative; display: flex; justify-content: flex-start; order: 0;">
        <img
            src="{{ asset('storage/assets/hiasan.png') }}"
            style="position: absolute; right: -2rem; top: 2rem; max-width: 30rem; min-width: 70%;"
        />
        <img
            src="{{ asset('storage/assets/orang.png') }}"
            alt="Orang"
            style="position: absolute; bottom: -3rem; transform: translateX(-10%); width: 100%; max-width: 50rem; min-width: 110%; max-height: 100%; z-index: 2;"
        />
    </div>
</div>
@endsection
