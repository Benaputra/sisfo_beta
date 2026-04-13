<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function login()
    {
        return view('portal.login');
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
