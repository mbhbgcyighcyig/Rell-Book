<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Redirect berdasarkan role setelah login
    protected function authenticated(Request $request, $user)
    {
        if ($user->isPeminjam()) {
            return redirect()->route('peminjam.dashboard');
        }
        return redirect()->route('dashboard');
    }
}
