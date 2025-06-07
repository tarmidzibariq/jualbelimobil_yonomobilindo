<!-- Modal Login -->
 <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content p-4">
             <div class="modal-header border-0">
                 <h5 class="modal-title w-100 text-center" id="loginModalLabel">Masuk</h5>
             </div>
             <div class="modal-body">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                     <div class="mb-3">
                         <label for="email" class="form-label fw-medium">Email*</label>
                         <input type="email" class="form-control py-2 border-0 @error('email') is-invalid @enderror" id="email" placeholder="Masukkan Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                     <div class="mb-3">
                         <label for="password" class="form-label fw-medium">Kata Sandi*</label>
                         <input type="password" class="form-control py-2 border-0 @error('password') is-invalid @enderror" id="password"
                             placeholder="Masukkan Kata Sandi" name="password" required autocomplete="current-password">
                     </div>
                     <div class="mb-3 form-check">
                         <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                         <label class="form-check-label " for="remember">Ingat Saya</label>
                     </div>

                     <button type="submit" class="btn btn-login w-100 mb-2">Masuk</button>
                     
                     <div class="text-center register-link">Belum Mempunyai Akun? <a href="#">Daftar</a></div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 