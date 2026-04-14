<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Skripsi;
use App\Models\PraktekLapang;
use App\Models\User;

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
        $notifications = $this->getNotifications();
        return view('portal.dashboard', compact('notifications'));
    }

    public function mahasiswa()
    {
        if (!auth()->user()->hasRole('mahasiswa')) {
            return redirect()->route('portal.dashboard')->with('error', 'Hanya mahasiswa yang dapat mengakses profil mahasiswa.');
        }
        $notifications = $this->getNotifications();
        return view('portal.mahasiswa', compact('notifications'));
    }

    public function seminar()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        if (!$mahasiswa && !$isStaff) {
            return redirect()->route('portal.riwayatSeminar')->with('error', 'Akses dibatasi.');
        }

        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        $mahasiswas = $isStaff ? \App\Models\Mahasiswa::orderBy('nama')->get() : [];
        $notifications = $this->getNotifications();
        return view('portal.seminar', compact('mahasiswa', 'dosens', 'notifications', 'mahasiswas', 'isStaff'));
    }

    public function storeSeminar(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');
        
        if (!$user->nim && !$isStaff) {
            return back()->with('error', 'Hanya mahasiswa dengan NIM yang dapat mendaftar.');
        }

        $validated = $request->validate([
            'nim' => $isStaff ? 'required|exists:mahasiswas,nim' : 'nullable',
            'judul' => 'required|string',
            'pembimbing1_id' => 'required|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
            'bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if (!$isStaff) {
            $validated['nim'] = $user->nim;
        }
        $validated['acc_seminar'] = 'Menunggu';

        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_bayar_seminar', 'public');
            $validated['bukti_bayar'] = $path;
        }

        try {
            Seminar::create($validated);
            return redirect()->route('portal.riwayatSeminar')->with('success', 'Pendaftaran seminar berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function editSeminar($id)
    {
        $seminar = Seminar::findOrFail($id);
        return response()->json($seminar);
    }

    public function updateSeminar(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string',
            'pembimbing1_id' => 'required|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id',
            'penguji_seminar_id' => 'nullable|exists:dosen,id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
            'acc_seminar' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_bayar_seminar', 'public');
            $validated['bukti_bayar'] = $path;
        }

        try {
            $seminar->update($validated);
            return redirect()->route('portal.riwayatSeminar')->with('success', 'Data seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroySeminar($id)
    {
        try {
            $seminar = Seminar::findOrFail($id);
            $seminar->delete();
            return redirect()->route('portal.riwayatSeminar')->with('success', 'Data seminar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function skripsi()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        if (!$mahasiswa && !$isStaff) {
            return redirect()->route('portal.riwayatSkripsi')->with('error', 'Akses dibatasi.');
        }

        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        $mahasiswas = $isStaff 
            ? \App\Models\Mahasiswa::whereHas('seminar', function($q) {
                $q->where('acc_seminar', 'Disetujui');
            })->orderBy('nama')->get() 
            : [];

        $notifications = $this->getNotifications();
        return view('portal.skripsi', compact('mahasiswa', 'dosens', 'notifications', 'mahasiswas', 'isStaff'));
    }

    public function storeSkripsi(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');
        
        if (!$user->nim && !$isStaff) {
            return back()->with('error', 'Hanya mahasiswa dengan NIM yang dapat mendaftar.');
        }

        $validated = $request->validate([
            'nim' => $isStaff ? 'required|exists:mahasiswas,nim' : 'nullable',
            'judul' => 'required|string',
            'pembimbing1_id' => 'required|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id',
            'bukti_bayar' => 'nullable|file|mimes:pdf|max:5120',
            'transkrip_nilai' => 'nullable|file|mimes:pdf|max:5120',
            'toefl' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if (!$isStaff) {
            $validated['nim'] = $user->nim;
        }

        foreach(['bukti_bayar', 'transkrip_nilai', 'toefl'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $path = $request->file($fileField)->store('skripsi_files', 'public');
                $validated[$fileField] = $path;
            }
        }

        try {
            Skripsi::create($validated);
            return redirect()->route('portal.riwayatSkripsi')->with('success', 'Pendaftaran skripsi berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function editSkripsi($id)
    {
        $skripsi = Skripsi::findOrFail($id);
        return response()->json($skripsi);
    }

    public function updateSkripsi(Request $request, $id)
    {
        $skripsi = Skripsi::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string',
            'pembimbing1_id' => 'required|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id',
            'penguji1_id' => 'nullable|exists:dosen,id',
            'penguji2_id' => 'nullable|exists:dosen,id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
        ]);

        try {
            $skripsi->update($validated);
            return redirect()->route('portal.riwayatSkripsi')->with('success', 'Data skripsi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroySkripsi($id)
    {
        try {
            $skripsi = Skripsi::findOrFail($id);
            $skripsi->delete();
            return redirect()->route('portal.riwayatSkripsi')->with('success', 'Data skripsi berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function praktekLapang()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        if (!$mahasiswa && !$isStaff) {
            return redirect()->route('portal.riwayatPraktekLapang')->with('error', 'Akses dibatasi.');
        }

        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        $mahasiswas = $isStaff ? \App\Models\Mahasiswa::orderBy('nama')->get() : [];
        $notifications = $this->getNotifications();
        return view('portal.praktek-lapang', compact('mahasiswa', 'dosens', 'notifications', 'mahasiswas', 'isStaff'));
    }

    public function storePraktekLapang(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');
        
        if (!$user->nim && !$isStaff) {
            return back()->with('error', 'Hanya mahasiswa dengan NIM yang dapat mendaftar.');
        }

        $validated = $request->validate([
            'nim' => $isStaff ? 'required|exists:mahasiswas,nim' : 'nullable',
            'lokasi' => 'required|string',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
            'bukti_bayar' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if (!$isStaff) {
            $validated['nim'] = $user->nim;
        }

        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('praktek_lapang_files', 'public');
            $validated['bukti_bayar'] = $path;
        }

        try {
            PraktekLapang::create($validated);
            return redirect()->route('portal.riwayatPraktekLapang')->with('success', 'Pendaftaran Praktek Lapang berhasil disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan pendaftaran: ' . $e->getMessage())->withInput();
        }
    }

    public function editPraktekLapang($id)
    {
        $praktek = PraktekLapang::findOrFail($id);
        return response()->json($praktek);
    }

    public function updatePraktekLapang(Request $request, $id)
    {
        $praktek = PraktekLapang::findOrFail($id);
        $validated = $request->validate([
            'lokasi' => 'required|string',
            'dosen_pembimbing_id' => 'required|exists:dosen,id',
            'laporan' => 'nullable|string',
        ]);

        try {
            $praktek->update($validated);
            return redirect()->route('portal.riwayatPraktekLapang')->with('success', 'Data Praktek Lapang berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroyPraktekLapang($id)
    {
        try {
            $praktek = PraktekLapang::findOrFail($id);
            $praktek->delete();
            return redirect()->route('portal.riwayatPraktekLapang')->with('success', 'Data Praktek Lapang berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function riwayatSeminar(Request $request)
    {
        $user = auth()->user();
        $query = Seminar::with(['mahasiswa', 'pembimbing1', 'pembimbing2', 'pengujiSeminar']);
        $notifications = $this->getNotifications();

        if ($user->hasRole('mahasiswa')) { $query->where('nim', $user->nim); }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function($mq) use ($search) {
                      $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }
        if ($request->filled('status')) { $query->where('acc_seminar', $request->status); }
        $seminars = $query->latest()->paginate(10)->withQueryString();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        return view('portal.riwayat-seminar', compact('seminars', 'notifications', 'dosens'));
    }

    public function riwayatSkripsi(Request $request)
    {
        $user = auth()->user();
        $query = Skripsi::with(['mahasiswa', 'pembimbing1', 'pembimbing2', 'penguji1', 'penguji2']);
        $notifications = $this->getNotifications();

        if ($user->hasRole('mahasiswa')) { $query->where('nim', $user->nim); }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function($mq) use ($search) {
                      $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }
        $skripsis = $query->latest()->paginate(10)->withQueryString();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        return view('portal.riwayat-skripsi', compact('skripsis', 'notifications', 'dosens'));
    }

    public function riwayatPraktekLapang(Request $request)
    {
        $user = auth()->user();
        $query = PraktekLapang::with(['mahasiswa', 'dosenPembimbing']);
        $notifications = $this->getNotifications();

        if ($user->hasRole('mahasiswa')) { $query->where('nim', $user->nim); }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")->orWhere('laporan', 'like', "%{$search}%")
                  ->orWhereHas('mahasiswa', function($mq) use ($search) {
                      $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }
        $prakteks = $query->latest()->paginate(10)->withQueryString();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        return view('portal.riwayat-prakteklapang', compact('prakteks', 'notifications', 'dosens'));
    }

    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        $user = auth()->user();
        $user->update(['theme' => $validated['theme']]);

        return response()->json(['success' => true]);
    }

    private function getNotifications()
    {
        $user = auth()->user();
        if (!$user) return [];

        $items = [];
        $recentThreshold = now()->subDays(3);

        if ($user->hasRole('mahasiswa')) {
            // Notifications for status change (detected by updated_at > created_at within threshold)
            $seminarCount = Seminar::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($seminarCount > 0) $items[] = "Status Seminar Anda telah diperbarui.";

            $skripsiCount = Skripsi::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($skripsiCount > 0) $items[] = "Status pendaftaran Skripsi Anda telah diperbarui.";

            $praktekCount = PraktekLapang::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($praktekCount > 0) $items[] = "Status Praktek Lapang Anda telah diperbarui.";
        }

        if ($user->hasRole('staff') || $user->hasRole('kaprodi')) {
            // Notifications for new data (penambahan data)
            $newSeminar = Seminar::where('created_at', '>=', $recentThreshold)->count();
            $newSkripsi = Skripsi::where('created_at', '>=', $recentThreshold)->count();
            $newPraktek = PraktekLapang::where('created_at', '>=', $recentThreshold)->count();
            
            if ($newSeminar > 0) $items[] = "Ada $newSeminar pendaftaran Seminar baru.";
            if ($newSkripsi > 0) $items[] = "Ada $newSkripsi pendaftaran Skripsi baru.";
            if ($newPraktek > 0) $items[] = "Ada $newPraktek pendaftaran Praktek Lapang baru.";
        }

        if ($user->hasRole('dosen')) {
            $dosen = $user->dosen;
            if ($dosen) {
                $dosenId = $dosen->id;
                // Penambahan data where NIDN used (assigned as supervisor/examiner)
                $newSeminar = Seminar::where('created_at', '>=', $recentThreshold)
                    ->where(function($q) use ($dosenId) {
                        $q->where('pembimbing1_id', $dosenId)->orWhere('pembimbing2_id', $dosenId)
                          ->orWhere('penguji_seminar_id', $dosenId)->orWhere('penguji2_id', $dosenId);
                    })->count();
                
                $newSkripsi = Skripsi::where('created_at', '>=', $recentThreshold)
                    ->where(function($q) use ($dosenId) {
                        $q->where('pembimbing1_id', $dosenId)->orWhere('pembimbing2_id', $dosenId)
                          ->orWhere('penguji1_id', $dosenId)->orWhere('penguji2_id', $dosenId);
                    })->count();
                
                $newPraktek = PraktekLapang::where('created_at', '>=', $recentThreshold)
                    ->where('dosen_pembimbing_id', $dosenId)->count();

                if ($newSeminar > 0) $items[] = "Anda ditunjuk sebagai pembimbing/penguji di $newSeminar Seminar baru.";
                if ($newSkripsi > 0) $items[] = "Anda ditunjuk sebagai pembimbing/penguji di $newSkripsi Skripsi baru.";
                if ($newPraktek > 0) $items[] = "Anda menjadi pembimbing di $newPraktek Praktek Lapang baru.";
            }
        }

        return $items;
    }
}
