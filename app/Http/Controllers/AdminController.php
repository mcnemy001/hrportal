<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kontrak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPegawai = Pegawai::count();
        $totalKontrakAktif = Kontrak::where('status', 'active')->count();
        $totalKontrakBerakhir = Kontrak::where('status', 'inactive')->count();
        $latestKontraks = Kontrak::with('pegawai')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalPegawai',
            'totalKontrakAktif',
            'totalKontrakBerakhir',
            'latestKontraks'
        ));
    }

    // Pegawai Management
    public function pegawaiIndex()
    {
        $pegawai = Pegawai::with('kontrakAktif')->get();
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function pegawaiCreate()
    {
        return view('admin.pegawai.create');
    }

    public function pegawaiStore(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:pegawai,nip',
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
            'email' => 'required|email|unique:pegawai,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => 'employee'
            ]);

            // Create pegawai with default status_pegawai
            $pegawai = new Pegawai();
            $pegawai->user_id = $user->id;
            $pegawai->nip = $validated['nip'];
            $pegawai->nama_lengkap = $validated['nama_lengkap'];
            $pegawai->tempat_lahir = $validated['tempat_lahir'];
            $pegawai->tanggal_lahir = $validated['tanggal_lahir'];
            $pegawai->jenis_kelamin = $validated['jenis_kelamin'];
            $pegawai->alamat = $validated['alamat'];
            $pegawai->nomor_telepon = $validated['nomor_telepon'];
            $pegawai->email = $validated['email'];
            $pegawai->status_pegawai = 'aktif'; // Set default status to 'aktif'
            $pegawai->save();

            DB::commit();

            return redirect()
                ->route('admin.pegawai.index')
                ->with('success', 'Pegawai berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menambahkan pegawai. ' . $e->getMessage()]);
        }
    }

    public function pegawaiEdit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    public function pegawaiUpdate(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:pegawai,nip,' . $pegawai->id,
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string',
            'email' => 'required|email|unique:pegawai,email,' . $pegawai->id,
            'status_pegawai' => 'required|string',
        ]);

        try {
            $pegawai->update($validated);

            return redirect()
                ->route('admin.pegawai.index')
                ->with('success', 'Data pegawai berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data pegawai.']);
        }
    }

    public function pegawaiDestroy(Pegawai $pegawai)
    {
        try {
            DB::beginTransaction();

            // Delete associated user
            if ($pegawai->user) {
                $pegawai->user->delete();
            }

            // Delete pegawai
            $pegawai->delete();

            DB::commit();

            return redirect()
                ->route('admin.pegawai.index')
                ->with('success', 'Pegawai berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus pegawai.']);
        }
    }

    // Kontrak Management
    public function kontrakIndex()
    {
        $kontrak = Kontrak::with('pegawai')->get();
        return view('admin.kontrak.index', compact('kontrak'));
    }

    public function kontrakCreate()
    {
        $pegawai = Pegawai::where('status_pegawai', 'aktif')->get();
        return view('admin.kontrak.create', compact('pegawai'));
    }

    public function kontrakStore(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'nomor_kontrak' => 'required|string|unique:kontrak,nomor_kontrak',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // Set previous contracts to inactive
            if ($validated['status'] === 'active') {
                Kontrak::where('pegawai_id', $validated['pegawai_id'])
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
            }

            // Create new contract
            Kontrak::create($validated);

            return redirect()
                ->route('admin.kontrak.index')
                ->with('success', 'Kontrak berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menambahkan kontrak. ' . $e->getMessage()]);
        }
    }

    public function kontrakEdit(Kontrak $kontrak)
    {
        $pegawai = Pegawai::where('status_pegawai', 'aktif')->get();
        return view('admin.kontrak.edit', compact('kontrak', 'pegawai'));
    }

    public function kontrakUpdate(Request $request, Kontrak $kontrak)
    {
        $validated = $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'nomor_kontrak' => 'required|string|unique:kontrak,nomor_kontrak,' . $kontrak->id,
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'keterangan' => 'nullable|string',
        ]);

        try {
            // Set previous contracts to inactive if this one is being set to active
            if ($validated['status'] === 'active' && $validated['pegawai_id'] !== $kontrak->pegawai_id) {
                Kontrak::where('pegawai_id', $validated['pegawai_id'])
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
            }

            $kontrak->update($validated);

            return redirect()
                ->route('admin.kontrak.index')
                ->with('success', 'Kontrak berhasil diperbarui');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kontrak.']);
        }
    }

    public function kontrakDestroy(Kontrak $kontrak)
    {
        try {
            $kontrak->delete();

            return redirect()
                ->route('admin.kontrak.index')
                ->with('success', 'Kontrak berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus kontrak.']);
        }
    }
}
