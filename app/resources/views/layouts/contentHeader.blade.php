
<!--begin::App Content Header-->
<div class="app-content-header">
  <!--begin::Container-->
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">
        @switch(true)
            @case(request()->routeIs('admin.dashboard'))
                Dashboard
                @break
            @case(request()->routeIs('admin.users.*'))
                Users
                @break
            @case(request()->routeIs('admin.cars.*'))
                Cars
                @break
            @default
                Halaman
        @endswitch
      </h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Home</a>
          </li>
      
          @switch(true)

            {{-- Dashboard --}}
            @case(request()->routeIs('admin.dashboard'))
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
              @break
      
            {{-- Users --}}
            @case(request()->routeIs('admin.users.index'))
              <li class="breadcrumb-item active" aria-current="page">Users</li>
              @break
      
            @case(request()->routeIs('admin.users.create'))
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
              @break
      
            @case(request()->routeIs('admin.users.edit'))
              <li class="breadcrumb-item">
                <a href="{{ route('admin.users.index') }}">Users</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
              @break

            {{-- cars --}}
            @case(request()->routeIs('admin.cars.index'))
              <li class="breadcrumb-item active" aria-current="page">Cars</li>
              @break
      
            @case(request()->routeIs('admin.cars.create'))
              <li class="breadcrumb-item">
                <a href="{{ route('admin.cars.index') }}">Cars</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Create</li>
              @break
      
            @case(request()->routeIs('admin.cars.edit'))
              <li class="breadcrumb-item">
                <a href="{{ route('admin.cars.index') }}">Cars</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
              @break
      
            @default
              <li class="breadcrumb-item active" aria-current="page">Halaman</li>
          @endswitch
        </ol>
      </div>
      
    </div>
    <!--end::Row-->
  </div>
  <!--end::Container-->
</div>