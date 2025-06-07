 <section id="navbar">
     <nav class="navbar navbar-expand-lg bg-white shadow-sm py-3 ">
         <div class="container">
             <!-- Logo -->
             <a class="navbar-brand d-flex align-items-center" href="#">
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
                         <a class="nav-link active" href="#">BELI MOBIL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">JUAL MOBIL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">TESTIMONIAL</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">KONTAK</a>
                     </li>
                 </ul>
                 <a class="btn btn-login px-5" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">MASUK</a>
             </div>
         </div>
     </nav>
 </section>

 <!-- Modal Login -->
 <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content p-4">
             <div class="modal-header border-0">
                 <h5 class="modal-title w-100 text-center" id="loginModalLabel">Masuk</h5>
             </div>
             <div class="modal-body">
                 <form>
                     <div class="mb-3">
                         <label for="email" class="form-label fw-medium">Email*</label>
                         <input type="email" class="form-control py-2 border-0" id="email" placeholder="Masukkan Email">
                     </div>
                     <div class="mb-3">
                         <label for="password" class="form-label fw-medium">Kata Sandi*</label>
                         <input type="password" class="form-control py-2 border-0" id="password"
                             placeholder="Masukkan Kata Sandi">
                     </div>
                     <div class="mb-3 form-check">
                         <input type="checkbox" class="form-check-input" id="remember">
                         <label class="form-check-label " for="remember">Ingat Saya</label>
                     </div>
                     <button type="submit" class="btn btn-login w-100 mb-2">Masuk</button>
                     <div class="text-center register-link">Belum Mempunyai Akun? <a href="#">Daftar</a></div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 
