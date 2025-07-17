<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Daftar YONOMOBILINDO</title>

    {{-- icon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/YONO-MOBILINDO-LOGO.svg') }}">

    <!-- font montserat -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --background: #fffdf6;
            --black: #171513;
            --grey: #867e77;
            --primary: #27548a;
            --yellow: #fcf259;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Montserrat", sans-serif;
            color: var(--black);
        }

        body {
            background-color: var(--background);
            background-color: #f8f9fa;
            /* height: 100vh; */
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-box {
            background-color: white;
            border: 1px solid #ccc;
            padding: 2.5rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            /* margin: 50px 0; */
        }

        .form-control {
            background-color: #f1f1f1;
            border: none;
        }

        .btn-daftar {
            background-color: var(--primary);
            color: var(--yellow);
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        }

        .btn-daftar:hover {
            /* Warna lebih gelap dari primary */
            background-color: #1f3f6b;
            /* Warna teks putih */
            color: #fff;
            /* Efek bayangan halus */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>

<body>

    <div class="register-box text-center rounded">
        <a href="{{route('home')}}">
            <img src="{{asset('image/Logo-Mobilindo-2.svg')}}" alt="YONOMOBILINDO LOGO"
                class="img-fluid mx-auto d-block mb-3" style="max-width: 200px;">

        </a>

        <h3 class="form-heading mb-1">Daftar</h3>
        <p class="text-muted mb-4">Segera mendaftar dan dapatkan keuntungan</p>
        <form method="POST" action="{{route('register')}}">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label fw-medium" for="name">Nama Lengkap*</label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Masukkan Nama Lengkap"  value="{{old('name')}}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 text-start">
                <label class="form-label fw-medium" for="email">Email*</label>
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email"  value="{{old('email')}}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 text-start">
                <label class="form-label fw-medium" for="password">Kata Sandi*</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan Kata Sandi" autocomplete="new-password" required>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-3 text-start">
                <label class="form-label fw-medium" for="konfirmasi-katasandi">Konfirmasi Kata Sandi*</label>
                <input type="password" id="konfirmasi-katasandi" class="form-control" name="password_confirmation" placeholder="Masukkan Konfirmasi Kata Sandi" required autocomplete="new-password" required>
            </div>
            <div class="mb-4 text-start">
                <label class="form-label fw-medium" for="phone">No. Telpon*</label>
                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" name="phone" placeholder="Masukkan No. Telpon" required>
            </div>
            <button type="submit" class="btn btn-daftar w-100">Daftar</button>
            <div class="text-center register-link mt-2">Sudah Mempunyai Akun? <a href="{{ route('login') }}">Login</a></div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
