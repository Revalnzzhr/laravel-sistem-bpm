@extends('layouts.app')

@section('content')
<!-- Flaticon CDN via Font Awesome -->
<link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css">

<style>
    .latarGradasi {
        background: linear-gradient(to bottom, #2654A1, #4989C2, #42ABDC);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .kotak {
        width: 100%;
        max-width: 400px;
        background-color: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 2rem;
        text-align: left;
        position: relative;
        z-index: 10;
    }

    .kotak img {
        width: 200px;
        margin-bottom: 1.5rem;
    }

    .kotak input {
        margin-bottom: 1rem;
    }

    .gambar-bawah {
        position: absolute;
        bottom: 0;
        width: 100%;
        z-index: 1;
    }

    .logout-button {
        width: 100%;
        padding: 10px;
        font-size: 1.2rem;
        color: white;
        background-color: #e74c3c;
        border: none;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
    }

    .logout-button:hover {
        background-color: #c0392b;
    }

    .user-info {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .user-info img {
        width: 40px;
        height: 40px;
        margin-right: 15px;
    }

    .user-info h5 {
        color: #2654a1;
        font-size: 1.4rem;
        margin: 0;
    }
</style>

@php
    $activeUser = request()->cookie('username') ?? 'Guest';
@endphp

<div class="latarGradasi">
    <div class="kotak">
        <div style="text-align: center;">
            <img src="{{ asset('storage/bpm-logo-biru.png') }}" alt="Logo">
        </div>

        <div class="user-info">
    <div class="d-flex align-items-center justify-content-center" style="width: 100%;">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077012.png" alt="User Icon" style="width: 40px; height: 40px; margin-right: 10px;">
        <div class="pb-3">
            <h5 style="color: #2654a1; font-size: 1.4rem; margin: 0; text-align: left;">{{ $activeUser }}</h5>
        </div>
        
    </div>
</div>



        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                <i class="fi fi-rs-leave" style="font-size: 1.5rem; margin-right: 0.5rem;"></i>
                Keluar
            </button>
        </form>
    </div>
</div>

<img src="{{ asset('storage/assets/bangunan.png') }}" alt="Bangunan" class="gambar-bawah">
@endsection
