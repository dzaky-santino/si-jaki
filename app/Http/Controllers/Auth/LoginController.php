<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
    
            Auth::user()->update([
                'last_login' => now()->setTimezone('UTC')
            ]);
    
            // Pastikan pengalihan langsung ke home setelah login
            return redirect()->route('home');
        }
    
        return back()->withErrors([
            'name' => 'Username atau Password salah',
        ])->with('error', 'Username atau Password salah')->onlyInput('name');
    }    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}