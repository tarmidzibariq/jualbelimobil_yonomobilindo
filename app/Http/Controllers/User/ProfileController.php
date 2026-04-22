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
        $request->validate([
            // 'name' => 'required|string|max:30',
            // 'email' => 'required|email|max:30|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:14',
            'address' => 'nullable|string|max:100',
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Update data user
        $user->phone = $request->phone;
        $user->address = $request->address;

        if (!empty($request->password)) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
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
