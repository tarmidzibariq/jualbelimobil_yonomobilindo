<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'YONO MOBILINDO') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap & Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- font montserat -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />

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
        }


        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .btn-login {
            background-color: var(--primary);
            color: var(--yellow);
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        }

        .btn-login:hover {
            /* Warna lebih gelap dari primary */
            background-color: #1f3f6b;
            /* Warna teks putih */
            color: #fff;
            /* Efek bayangan halus */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        header {
            background-color: #ffffff;
            padding: 1rem 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        header img {
            max-width: 200px;
            height: auto;
        }

        main {
            flex: 1;
            padding: 2rem 1rem;
        }

        footer {
            background-color: #032145;
            color: #fff;
            text-align: center;
            padding: 1rem;
            font-size: 14px;
        }

    </style>
</head>

<body>
    <div id="app">
        <header>
            <img src="{{ asset('image/YONO-MOBILINDO-LOGO.svg') }}" alt="YONO MOBILINDO LOGO">
        </header>

        <main class="container">
            @yield('content')
        </main>

        <footer>
            &copy; {{ date('Y') }} YONO MOBILINDO. All rights reserved.
        </footer>
    </div>
</body>

</html>
