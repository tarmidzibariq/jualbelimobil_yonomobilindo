<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="{{route('home')}}" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="{{ asset('image/YONO MOBILINDO LOGO 2.png') }}"
        alt="YONO MOBILINDO"
        class="brand-image  shadow"
      />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">YONOMOBILINDO</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
      @auth
        @if(auth()->user()->role === 'admin')
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <i class="nav-icon bi bi-people-fill"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.cars.index') }}" class="nav-link {{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
              <i class=" nav-icon fa-solid fa-car"></i>
              <p>
                Cars
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.downPayment.index') }}" class="nav-link {{ request()->routeIs('admin.downPayment.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-money-bill"></i>
              <p>
                DownPayment(DP)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.offer.index') }}" class="nav-link {{ request()->routeIs('admin.offer.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-car-side"></i>
              <p>
                Offer Cars
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.salesRecord.index') }}" class="nav-link {{ request()->routeIs('admin.salesRecord.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-car-side"></i>
              <p>
                Transaction Sales Record 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.offerRecord.index') }}" class="nav-link {{ request()->routeIs('admin.offerRecord.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-shop"></i>
              <p>
                Transaction Offer Record 
              </p>
            </a>
          </li>
          
          @elseif(auth()->user()->role === 'user')
          <li class="nav-item">
            <a href="{{ route('user.dashboard')}}" class="nav-link {{ request()->routeIs('home-cms') ? 'active' : '' }}">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('user.downPayment.index')}}" class="nav-link {{ request()->routeIs('user.downPayment.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-money-bill"></i>
              <p>
                DownPayment(DP)
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('user.offer.index')}}" class="nav-link {{ request()->routeIs('user.offer.*') ? 'active' : '' }}">
              <i class="nav-icon fa-solid fa-car-side"></i>
              <p>
                Penjualan Mobil
              </p>
            </a>
          </li>
        @endif
        
      @endauth

      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>