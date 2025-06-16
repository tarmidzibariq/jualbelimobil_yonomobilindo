<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Yono Mobilindo</title>

    <meta name="title" content="Yono Mobilindo" />

    {{-- icon --}}
    <link rel="icon" type="image/png" href="{{ asset('image/YONO-MOBILINDO-LOGO.svg') }}">

    @include('web.layouts.css')

    @stack('web-styles')
</head>

<body>

    {{-- navbar --}}
    @include('web.layouts.navbar')

    {{-- modal Login --}}
    @include('web.auth.login')
    
    {{-- content --}}
    @yield('web-content')

    <!-- start footer -->
   @include('web.layouts.footer')
    <!-- end footer -->
    
    {{-- js --}}
    @include('web.layouts.js')

    @stack('web-scripts')
</body>

</html>
