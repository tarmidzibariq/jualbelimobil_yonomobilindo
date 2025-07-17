<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
