<?php

namespace App\Http\Controllers\User;

use App\Helpers\WhatsAppHelper;
use App\Http\Controllers\Controller;
use App\Models\OtpKode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'checkrole:user']);
    }

    public function index() {
        $user = User::find(Auth::id());
        return view('user.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        // Cari user yang sedang login
        $user = User::findOrFail(Auth::id());

        // Validasi input
        $validated = $request->validate([
            // 'name' => 'required|string|max:30',
            // 'email' => 'required|email|max:30|unique:users,email,' . $user->id,
            'phone' => ['required', 'string', 'max:16', 'regex:/^[0-9+\-\s]+$/'],
            'address' => 'nullable|string|max:100',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $normalizedNewPhone = WhatsAppHelper::normalizePhone($validated['phone']);
        $normalizedCurrentPhone = WhatsAppHelper::normalizePhone($user->phone);

        // Update data user
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];

        if ($normalizedNewPhone !== $normalizedCurrentPhone) {
            $user->whatsapp_verified_at = null;
        }

        if (!empty($request->password)) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function sendWhatsappOtp(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'phone' => ['required', 'string', 'max:16', 'regex:/^[0-9+\-\s]+$/'],
        ]);

        $normalizedPhone = WhatsAppHelper::normalizePhone($request->phone);
        if (!$normalizedPhone) {
            return back()->withErrors(['phone' => 'Nomor WhatsApp tidak valid.']);
        }

        $lastOtp = OtpKode::where('user_id', $user->id)->latest()->first();
        if ($lastOtp && $lastOtp->created_at->gt(now()->subMinute())) {
            return back()->with('error', 'Tunggu 1 menit sebelum meminta kode OTP baru.');
        }

        $otpCode = (string) random_int(1000, 9999);

        OtpKode::where('user_id', $user->id)->delete();

        OtpKode::create([
            'kode' => $otpCode,
            'user_id' => $user->id,
            'phone' => $normalizedPhone,
            'expires_at' => now()->addMinutes(5),
        ]);

        $user->phone = $request->phone;
        $user->whatsapp_verified_at = null;
        $user->save();

        $isSent = WhatsAppHelper::send(
            $normalizedPhone,
            "Kode OTP verifikasi WhatsApp Anda: {$otpCode}. Berlaku 5 menit. Jangan bagikan ke siapa pun.",
            [
                'event' => 'whatsapp_verification_otp',
                'user_id' => $user->id,
            ]
        );

        if (!$isSent) {
            return back()->with('error', 'Gagal mengirim OTP ke WhatsApp. Pastikan nomor benar dan coba lagi.');
        }

        return back()->with('success', 'Kode OTP berhasil dikirim ke WhatsApp Anda.');
    }

    public function verifyWhatsappOtp(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'otp_code' => ['required', 'digits:4'],
        ]);

        $otp = OtpKode::where('user_id', $user->id)
            ->where('kode', $request->otp_code)
            ->latest()
            ->first();

        if (!$otp) {
            return back()->with('error', 'Kode OTP tidak valid.');
        }

        if (Carbon::parse($otp->expires_at)->isPast()) {
            return back()->with('error', 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang OTP.');
        }

        $user->phone = $otp->phone;
        $user->whatsapp_verified_at = now();
        $user->save();

        OtpKode::where('user_id', $user->id)->delete();

        return back()->with('success', 'Nomor WhatsApp berhasil diverifikasi.');
    }

    public function updateAddress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Pastikan hanya user yang sedang login yang bisa update datanya sendiri
        if ($user->id !== Auth::id()) {
            abort(403, 'Tidak diizinkan memperbarui data ini.');
        }

        // Update address
        $user->address = $request->address;
        $user->save();

        return back()->with('success', 'Alamat berhasil diperbarui.');
    }
}
