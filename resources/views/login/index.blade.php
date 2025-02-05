
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Sistem BPM</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            width: 30rem;
            max-width: 90%;
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
    </style>
</head>

<body>
    <div class="latarGradasi">
        <div class="kotak">
            <div style="text-align: center;">
                <img src="{{ asset('storage/bpm-logo-biru.png') }}" alt="Logo">
            </div>
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <div class="mb-3">
                    <label for="username" class="form-label mb-3">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label mb-3">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
        <img src="{{ asset('storage/assets/bangunan.png') }}" alt="Bangunan" class="gambar-bawah">
    </div>
</body>

</html>
