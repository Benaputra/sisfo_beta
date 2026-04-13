<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return redirect()->route('portal.dashboard');
        }
        return view('portal.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $identity = $request->input('identity');

        if (auth()->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            // Check if user has the selected role/identity
            if ($identity === 'mahasiswa' && !$user->hasRole('mahasiswa')) {
                auth()->logout();
                return back()->withErrors(['email' => 'Akun anda bukan Mahasiswa.'])->withInput();
            }

            if ($identity === 'dosen' && !$user->hasRole('dosen')) {
                auth()->logout();
                return back()->withErrors(['email' => 'Akun anda bukan Dosen.'])->withInput();
            }

            if ($identity === 'sivitas' && !($user->hasRole('staff') || $user->hasRole('kaprodi') || $user->hasRole('admin'))) {
                auth()->logout();
                return back()->withErrors(['email' => 'Akun anda bukan Sivitas.'])->withInput();
            }

            // If everything is okay, redirect to portal dashboard
            return redirect()->intended(route('portal.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('portal.dashboard');
    }

    public function mahasiswa()
    {
        return view('portal.mahasiswa');
    }

    public function seminar()
    {
        return view('portal.seminar');
    }

    public function skripsi()
    {
        return view('portal.skripsi');
    }

    public function praktekLapang()
    {
        return view('portal.praktek-lapang');
    }

    public function riwayatSeminar()
    {
        return view('portal.riwayat-seminar');
    }

    public function riwayatSkripsi()
    {
        return view('portal.riwayat-skripsi');
    }

    public function riwayatPraktekLapang()
    {
        return view('portal.riwayat-prakteklapang');
    }
}
