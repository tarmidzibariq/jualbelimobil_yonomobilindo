
<!-- Modal Login -->
<div class="modal fade d-block" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-modal="true"
    role="dialog">
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
                        <input id="email" type="email"
                            class="form-control py-2 border-0 @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Masukkan Email">

                        @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium">Kata Sandi*</label>
                        <input id="password" type="password"
                            class="form-control py-2 border-0 @error('password') is-invalid @enderror" name="password"
                            required autocomplete="current-password" placeholder="Masukkan Kata Sandi">

                        @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check text-start">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login w-100 mb-2">Masuk</button>

                    @if (Route::has('register'))
                    <div class="text-center register-link">
                        Belum Mempunyai Akun? <a href="{{ route('register') }}">Daftar</a>
                    </div>
                    @endif

                    @if (Route::has('password.request'))
                    <div class="text-center mt-2">
                        <a class="text-decoration-none" href="{{ route('password.request') }}">
                            Lupa Kata Sandi?
                        </a>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
