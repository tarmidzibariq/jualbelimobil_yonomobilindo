<div class="app-content">
  <div class="container-fluid">
    <div class="mb-2">
      @auth
        @if(auth()->user()->role === 'user' && !auth()->user()->whatsapp_verified_at)
          <div class="alert alert-warning mt-3 mb-0" role="alert">
            Nomor WhatsApp Anda belum terverifikasi. Silakan verifikasi terlebih dahulu di halaman
            <a href="{{ route('user.profile.index') }}" class="alert-link">Profil</a>
            agar dapat melakukan transaksi.
          </div>
        @endif
      @endauth
    </div>
  </div>
</div>