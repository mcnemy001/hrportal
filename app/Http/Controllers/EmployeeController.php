<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Kontrak;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        if (!auth()->check() || auth()->user()->role !== 'employee') {
            return redirect('/');
        }
    
        $pegawai = Pegawai::where('user_id', auth()->id())->first();
        $kontrakAktif = Kontrak::where('pegawai_id', $pegawai->id)
            ->where('tanggal_berakhir', '>=', now())
            ->orderBy('tanggal_mulai', 'desc')
            ->first();
        
        $riwayatKontrak = Kontrak::where('pegawai_id', $pegawai->id)
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
    
        return view('employee.dashboard', compact('pegawai', 'kontrakAktif', 'riwayatKontrak'));
    }

    public function profile()
    {
        if (!auth()->check() || auth()->user()->role !== 'employee') {
            return redirect('/');
        }

        return view('employee.profile');
    }

    public function updateProfile(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'employee') {
            return redirect('/');
        }

        $pegawai = auth()->user()->pegawai;

        $validated = $request->validate([
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:pegawai,email,' . $pegawai->id,
            'alamat' => 'required|string',
        ]);

        try {
            $pegawai->update($validated);

            return back()->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil.']);
        }
    }

    public function kontrak()
    {
        if (!auth()->check() || auth()->user()->role !== 'employee') {
            return redirect('/');
        }

        $pegawai = Pegawai::where('user_id', auth()->id())->first();
        $kontrak = Kontrak::where('pegawai_id', $pegawai->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employee.kontrak', compact('kontrak'));
    }
}
