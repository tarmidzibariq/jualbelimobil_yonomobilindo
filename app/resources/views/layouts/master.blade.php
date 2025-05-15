<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="Administrator YonoMobilindo"
    />
    <meta
      name="keywords"
      content="Administrator YonoMobilindo"/>
    <!--end::Primary Meta Tags-->
    
    @include('layouts.css')

    @stack('styles')
  </head>
  <!--end::Head-->
  
  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

    <!--begin::App Wrapper-->
    <div class="app-wrapper">

      <!--begin::Header-->
      @include('layouts.navbar')
      <!--end::Header-->

      <!--begin::Sidebar-->
      @include('layouts.sidebar')
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">

        <!--begin::App Content Header-->
        @include('layouts.contentHeader')
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="container">
          
        </div>
        @yield('content')
        <!--end::App Content-->

      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      @include('layouts.footer')

      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @include('layouts.js')
    @stack('scripts')
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
