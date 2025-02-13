<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kontrak;

class KaryawanController extends Controller
{
    public function dashboard()
    {
        $pegawai = Auth::user()->pegawai;
        $kontrakAktif = $pegawai->kontrakAktif;
        $riwayatKontrak = $pegawai->kontrak()
            ->with('riwayat')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('karyawan.dashboard', compact('pegawai', 'kontrakAktif', 'riwayatKontrak'));
    }

    public function kontrak()
    {
        $pegawai = Auth::user()->pegawai;
        $kontrak = $pegawai->kontrak()
            ->with('riwayat')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('karyawan.kontrak', compact('pegawai', 'kontrak'));
    }
}
