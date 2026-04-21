<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\WhatsAppHelper;
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

            // Hindari menyimpan redirect ke /login atau ke /user/dashboard
            if (!str_contains($redirect, '/login') && !str_contains($redirect, '/dashboard')) {
                session(['url.intended' => $redirect]);
            }
        }

        if (isset($redirect) && str_contains($redirect, '/admin')) {
            return view('auth.login');
        }

        // Hindari redirect loop kalau asalnya dari halaman butuh login
        if (url()->previous() === url()->current() || str_contains(url()->previous(), '/dashboard')) {
            return redirect('/');
        }

        return redirect()->back()->with('showLoginModal', true);
    }



    protected function authenticated(Request $request, $user)
    {
        WhatsAppHelper::send(
            $user->phone ?? null,
            "Halo {$user->name}, login ke akun YonoMobilindo berhasil.",
            [
                'event' => 'user_login',
                'user_id' => $user->id,
            ]
        );
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
