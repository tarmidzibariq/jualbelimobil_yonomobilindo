<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm(Request $request)
{
    if ($request->has('redirect')) {
        $redirect = $request->redirect;

        // 🔒 Jangan simpan redirect ke /login ke session
        if (!str_contains($redirect, '/login')) {
            session(['url.intended' => $redirect]);
        }
    }

    // CMS pakai halaman login, lainnya pakai modal login
    if (isset($redirect) && str_contains($redirect, '/admin')) {
        return view('auth.login');
    }

    return redirect()->back()->with('showLoginModal', true);
}


    

    // protected function authenticated(Request $request, $user)
    // {
    //     // Kalau ada redirect yang valid, gunakan
    //     if (session()->has('url.intended') && !str_contains(session('url.intended'), '/login')) {
    //         return redirect()->intended();
    //     }

    //     // Kalau tidak ada → arahkan berdasarkan role
    //     if ($user->role === 'admin') {
    //         return redirect('/admin/dashboard');
    //     }

    //     if ($user->role === 'user') {
    //         return redirect('/user/dashboard');
    //     }

    //     return redirect('/');
    // }

}
