 <section id="navbar">
     <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 ">
         <div class="container">
             <!-- Logo -->
             <a class="navbar-brand d-flex align-items-center" href="{{route('home')}}">
                 <img src="{{asset('image/Logo-Mobilindo-2.svg')}}" alt="Logo" width="150" class="me-2" />
             </a>

             <!-- Custom toggle button -->
             <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                 aria-label="Toggle navigation">
                 <span></span>
                 <span></span>
                 <span></span>
             </button>


             <!-- Menu -->
             <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                 <ul class="navbar-nav mb-2 mb-lg-0">
                     <li class="nav-item">
                         <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{route('home')}}">BELI MOBIL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{ request()->routeIs('web.jualMobil.*') ? 'active' : '' }}" href="{{ route('web.jualMobil.index')}}">JUAL MOBIL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{request()->routeIs('web.testimonial') ? 'active' : ''}}" href="{{route('web.testimonial')}}">TESTIMONIAL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link {{request()->routeIs('web.kontak') ? 'active' : ''}}" href="{{route('web.kontak')}}">KONTAK</a>
                     </li>
                 </ul>
                 {{-- Jika belum login --}}
                 @guest
                 <button type="button" class="btn btn-login px-5" data-bs-toggle="modal" data-bs-target="#loginModal">
                     MASUK
                 </button>
                 @endguest

                 {{-- Jika sudah login --}}
                 @auth
                 <a href="{{ route('home-cms') }}" class="btn btn-login px-4">
                     DASHBOARD
                 </a>
                 @endauth
             </div>
         </div>
     </nav>
 </section>
