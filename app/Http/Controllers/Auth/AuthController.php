<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
    
            if ($user->role === 'admin') {
                toast()->success('Hallo', 'Selamat Datang ' . $user->username);
                return redirect()->route('home'); // Direktori ke halaman Admin
            } elseif ($user->role === 'pegawai') {
                toast()->success('Hallo', 'Selamat Datang ' . $user->username);
                return redirect()->route('arsip'); // Direktori ke halaman Pegawai
            }

        }
    
        // Jika login gagal karena kredensial salah
        toast()->error('Gagal', 'Email atau password yang Anda masukkan salah.');
        return back()->withInput();
    }
    

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toast()->success('Berhasil', 'Anda telah logout');
        return redirect('/');
    }
}
