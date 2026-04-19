<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seminar;
use App\Models\Skripsi;
use App\Models\PraktekLapang;
use App\Models\User;
use App\Models\Surat;
use App\Models\PengajuanJudul;
use App\Models\Mahasiswa;

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
        $mahasiswas = []; // Loaded via AJAX search
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
            'nim' => $isStaff ? 'required|exists:mahasiswa,nim' : 'nullable',
            'judul' => 'required|string',
            'pembimbing1_id' => $isStaff ? 'required|exists:dosen,id' : 'nullable|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
            'bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'pembimbing2_id.different' => 'Pembimbing 2 tidak boleh sama dengan Pembimbing 1.',
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
            'pembimbing2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id',
            'penguji_seminar_id' => 'nullable|exists:dosen,id|different:pembimbing1_id|different:pembimbing2_id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
            'acc_seminar' => 'required|in:Menunggu,Disetujui,Ditolak',
            'is_kesediaan_valid' => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ], [
            'pembimbing2_id.different' => 'Pembimbing 2 tidak boleh sama dengan Pembimbing 1.',
            'penguji_seminar_id.different' => 'Penguji tidak boleh sama dengan Pembimbing 1 atau 2.',
        ]);

        $validated['is_kesediaan_valid'] = $request->has('is_kesediaan_valid');

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

            // Hapus Pengajuan Judul terkait jika ada (Cascade Manual)
            if ($seminar->pengajuan_judul_id) {
                PengajuanJudul::where('id', $seminar->pengajuan_judul_id)->delete();
            }

            $seminar->delete();
            return redirect()->route('portal.riwayatSeminar')->with('success', 'Data seminar berhasil dihapus beserta data pengajuan judul terkait.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function sendSeminarNotification(Request $request, $id, \App\Services\WhatsAppService $waService)
    {
        $seminar = Seminar::findOrFail($id);
        $mahasiswa = $seminar->mahasiswa;

        if (!$mahasiswa || !$mahasiswa->no_hp) {
            return response()->json(['success' => false, 'message' => 'Mahasiswa atau nomor HP tidak ditemukan.']);
        }

        $hour = now()->format('H');
        $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));

        $brandText = "kami dari Fakultas Pertanian, Sains dan Teknologi Universitas Panca Bhakti Pontianak.";

        if ($seminar->canGenerateSurat()) {
            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Undangan seminar sudah dapat didownload pada sistem informasi FPST UPB. Terima Kasih.";
        } elseif ($seminar->file_kesediaan) {
            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Bimbingan Anda sedang divalidasi. Mohon cek berkala untuk mengunduh Surat Undangan Seminar jika sudah disetujui. Terima Kasih.";
        } elseif ($seminar->canDownloadKesediaan()) {
            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Bimbingan sudah dapat diunduh di sistem. Silakan diprint dan dimintakan tanda tangan dosen pembimbing, lalu unggah kembali scan surat tersebut ke portal. Terima Kasih.";
        } else {
            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Pendaftaran seminar Anda sedang dalam proses verifikasi staff. Terima Kasih.";
        }

        $success = $waService->send($mahasiswa->no_hp, $message);

        if ($success) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal mengirim pesan melalui Wablas.']);
    }

    public function downloadUndanganSeminar($id)
    {
        $seminar = Seminar::findOrFail($id);

        if (!$seminar->canGenerateSurat()) {
            return back()->with('error', 'Surat belum dapat diunduh. Pastikan Pembimbing, Penguji, Bukti Bayar, Status Disetujui, dan Surat Kesediaan sudah divalidasi oleh Staff.');
        }

        $mahasiswa = $seminar->mahasiswa;
        $prodi = $mahasiswa->programStudi;

        // Find existing or create placeholder Surat record
        $surat = $seminar->suratUndangan;
        if (!$surat) {
            $surat = Surat::create([
                'jenis_surat' => 'Undangan Seminar',
                'no_surat' => 'UN1/FP/STUDI-' . rand(100, 999) . '/2026',
                'tujuan_surat' => $mahasiswa->nama,
            ]);
            $seminar->update(['surat_undangan_id' => $surat->id]);
        }

        $data = [
            'seminar' => $seminar,
            'mahasiswa' => $mahasiswa,
            'surat' => $surat,
            'with_signature' => true,
            'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
            'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
            'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-undangan-seminar', $data);
        $filename = 'surat_undangan_' . $seminar->nim . '.pdf';

        return $pdf->stream($filename);
    }

    public function downloadKesediaanSeminar($id)
    {
        $seminar = Seminar::with(['mahasiswa.programStudi', 'pembimbing1', 'pembimbing2', 'suratKesediaan'])->findOrFail($id);

        if (!$seminar->canDownloadKesediaan()) {
            return back()->with('error', 'Surat kesediaan belum tersedia. Pastikan Staff sudah menentukan pembimbing & upload bukti bayar.');
        }

        $mahasiswa = $seminar->mahasiswa;
        $prodi = $mahasiswa->programStudi;

        // Find existing or create placeholder Surat record
        $surat = $seminar->suratKesediaan;
        if (!$surat) {
            $surat = Surat::create([
                'jenis_surat' => 'Surat Kesediaan Seminar',
                'no_surat' => 'UN1/FP/KES-' . rand(100, 999) . '/2026',
                'tujuan_surat' => $mahasiswa->nama,
            ]);
            $seminar->update(['surat_kesediaan_id' => $surat->id]);
        }

        $data = [
            'seminar' => $seminar,
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
            'surat' => $surat,
            'with_signature' => true,
            'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
            'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
            'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-kesediaan-seminar', $data);
        $filename = 'surat_kesediaan_seminar_' . $seminar->nim . '.pdf';

        return $pdf->stream($filename);
    }

    public function uploadKesediaanSeminar(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);

        $request->validate([
            'file_kesediaan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_kesediaan')) {
            $path = $request->file('file_kesediaan')->store('seminar/kesediaan', 'public');
            $seminar->update([
                'file_kesediaan' => $path,
                'is_kesediaan_valid' => false, // Reset validasi jika upload ulang
            ]);
            return back()->with('success', 'Surat Kesediaan Seminar berhasil diunggah. Silakan tunggu validasi dari Staff.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    public function skripsi()
    {
        $user = auth()->user();
        $mahasiswa = $user->mahasiswa;
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        if (!$mahasiswa && !$isStaff) {
            return redirect()->route('portal.riwayatSkripsi')->with('error', 'Akses dibatasi.');
        }

        // Student must have an approved title first
        if (!$isStaff && $mahasiswa) {
            $judul = PengajuanJudul::where('nim', $mahasiswa->nim)->where('status', 'disetujui')->first();
            if (!$judul) {
                return redirect()->route('portal.pengajuanJudul')->with('error', 'Anda harus mengajukan judul skripsi dan disetujui terlebih dahulu.');
            }
        }

        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        $mahasiswas = []; // Loaded via AJAX search

        $notifications = $this->getNotifications();
        $approvedJudul = !$isStaff && $mahasiswa ? PengajuanJudul::where('nim', $mahasiswa->nim)->where('status', 'disetujui')->first() : null;

        return view('portal.skripsi', compact('mahasiswa', 'dosens', 'notifications', 'mahasiswas', 'isStaff', 'approvedJudul'));
    }

    public function storeSkripsi(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        if (!$user->nim && !$isStaff) {
            return back()->with('error', 'Hanya mahasiswa dengan NIM yang dapat mendaftar.');
        }

        $validated = $request->validate([
            'nim' => $isStaff ? 'required|exists:mahasiswa,nim' : 'nullable',
            'judul' => 'required|string',
            'pembimbing1_id' => 'required|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id',
            'bukti_bayar' => 'nullable|file|mimes:pdf|max:5120',
            'transkrip_nilai' => 'nullable|file|mimes:pdf|max:5120',
            'toefl' => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'pembimbing2_id.different' => 'Pembimbing 2 tidak boleh sama dengan Pembimbing 1.',
        ]);

        if (!$isStaff) {
            $validated['nim'] = $user->nim;
        }

        foreach (['bukti_bayar', 'transkrip_nilai', 'toefl'] as $fileField) {
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
            'pembimbing2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id',
            'penguji1_id' => 'nullable|exists:dosen,id|different:pembimbing1_id|different:pembimbing2_id',
            'penguji2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id|different:pembimbing2_id|different:penguji1_id',
            'tanggal' => 'nullable|date',
            'tempat' => 'nullable|string',
        ], [
            'pembimbing2_id.different' => 'Pembimbing 2 tidak boleh sama dengan Pembimbing 1.',
            'penguji1_id.different' => 'Penguji 1 tidak boleh sama dengan Pembimbing.',
            'penguji2_id.different' => 'Penguji 2 tidak boleh sama dengan Pembimbing atau Penguji 1.',
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
        $mahasiswas = []; // Loaded via AJAX search
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
            'nim' => $isStaff ? 'required|exists:mahasiswa,nim' : 'nullable',
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

    public function pengajuanJudul(Request $request)
    {
        $user = auth()->user();
        $isMahasiswa = $user->hasRole('mahasiswa');
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');
        $notifications = $this->getNotifications();

        $query = PengajuanJudul::with('mahasiswa');

        if ($isMahasiswa) {
            $query->where('nim', $user->nim);
            $mahasiswa = $user->mahasiswa;
            $existingSubmission = PengajuanJudul::where('nim', $user->nim)->first();
        } else {
            $mahasiswa = null;
            $existingSubmission = null;
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();

        return view('portal.pengajuan-judul', compact('pengajuans', 'notifications', 'mahasiswa', 'isStaff', 'isMahasiswa', 'existingSubmission'));
    }

    public function riwayatPengajuanJudul(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');
        $notifications = $this->getNotifications();

        $query = PengajuanJudul::with(['mahasiswa', 'pembimbing1', 'pembimbing2']);

        if (!$isStaff) {
            $query->where('nim', $user->nim);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();
        $hasApproved = !$isStaff ? PengajuanJudul::where('nim', $user->nim)->where('status', 'disetujui')->exists() : false;
        $hasPending = !$isStaff ? PengajuanJudul::where('nim', $user->nim)->where('status', 'pending')->exists() : false;
        $dosens = \App\Models\Dosen::orderBy('nama')->get();

        return view('portal.riwayat-pengajuan-judul', compact('pengajuans', 'notifications', 'isStaff', 'hasApproved', 'hasPending', 'dosens'));
    }

    public function searchMahasiswa(Request $request)
    {
        $search = $request->input('q');
        $type = $request->input('type');

        $query = Mahasiswa::where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%");
        });

        if ($type === 'skripsi') {
            $query->whereHas('seminar', function ($q) {
                $q->where('acc_seminar', 'Disetujui');
            });
        }

        $mahasiswas = $query->limit(20)->get();

        $results = $mahasiswas->map(function ($m) {
            return [
                'id' => $m->nim,
                'text' => $m->nim . ' - ' . $m->nama
            ];
        });

        return response()->json($results);
    }

    public function storePengajuanJudul(Request $request)
    {
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        $request->validate([
            'nim' => $isStaff ? 'required|exists:mahasiswa,nim' : 'nullable',
            'judul' => 'required|string|max:500',
            'bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $nim = $isStaff ? $request->nim : $user->nim;
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        // Validation for students: must upload proof if 2020 or older
        if (!$isStaff && $mahasiswa->angkatan <= 2020 && !$request->hasFile('bukti_bayar')) {
            return back()->withErrors(['bukti_bayar' => 'Bukti pembayaran wajib untuk Angkatan 2020 ke bawah.'])->withInput();
        }

        // Check if already submitted
        if (PengajuanJudul::where('nim', $nim)->exists()) {
            return redirect()->back()->with('error', 'Mahasiswa ' . $nim . ' sudah memiliki pengajuan judul.');
        }

        $path = $request->hasFile('bukti_bayar') ? $request->file('bukti_bayar')->store('bukti_bayar_judul', 'public') : null;

        PengajuanJudul::create([
            'nim' => $nim,
            'judul' => $request->judul,
            'bukti_bayar' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('portal.riwayatPengajuanJudul')->with('success', 'Judul skripsi berhasil diajukan.');
    }


    public function approvePengajuanJudul(Request $request, $id)
    {
        $user = auth()->user();
        if (!$user->hasRole('staff') && !$user->hasRole('kaprodi')) {
            return back()->with('error', 'Akses ditolak.');
        }

        $validated = $request->validate([
            'no_surat' => 'required|string',
            'pembimbing1_id' => 'nullable|exists:dosen,id',
            'pembimbing2_id' => 'nullable|exists:dosen,id|different:pembimbing1_id',
            'keterangan' => 'nullable|string',
        ], [
            'pembimbing2_id.different' => 'Pembimbing 2 tidak boleh sama dengan Pembimbing 1.',
        ]);

        $pengajuan = PengajuanJudul::with('mahasiswa')->findOrFail($id);

        // Create record in surats table
        $surat = Surat::create([
            'jenis_surat' => 'Surat Kesediaan Bimbingan',
            'no_surat' => $validated['no_surat'],
            'tujuan_surat' => $pengajuan->mahasiswa->nama,
        ]);

        $pengajuan->update([
            'status' => 'disetujui',
            'no_surat' => $validated['no_surat'],
            'surat_id' => $surat->id,
            'pembimbing1_id' => $validated['pembimbing1_id'],
            'pembimbing2_id' => $validated['pembimbing2_id'],
            'keterangan' => $validated['keterangan'],
            'surat_kesediaan' => 'generated',
        ]);

        return redirect()->route('portal.riwayatPengajuanJudul')->with('success', 'Judul disetujui, Nomor Surat dicatat di sistem, dan Surat Kesediaan diterbitkan.');
    }

    public function uploadKesediaanJudul(Request $request, $id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);

        $request->validate([
            'file_kesediaan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('file_kesediaan')) {
            $path = $request->file('file_kesediaan')->store('pengajuan_judul/kesediaan', 'public');
            $pengajuan->update([
                'file_kesediaan' => $path,
                'is_kesediaan_valid' => false,
            ]);
            return back()->with('success', 'Surat kesediaan berhasil diunggah. Silakan tunggu validasi dari Staff.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    public function quickValidateJudul(Request $request, $id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);
        $pengajuan->update([
            'is_kesediaan_valid' => true,
        ]);

        // Teruskan data ke tabel seminar
        Seminar::updateOrCreate(
            ['pengajuan_judul_id' => $pengajuan->id],
            [
                'nim' => $pengajuan->nim,
                'judul' => $pengajuan->judul,
                'pembimbing1_id' => $pengajuan->pembimbing1_id,
                'pembimbing2_id' => $pengajuan->pembimbing2_id,
                'acc_seminar' => 'Menunggu',
                'bukti_bayar' => $pengajuan->bukti_bayar,
                'is_kesediaan_valid' => true,
                'file_kesediaan' => $pengajuan->file_kesediaan,
                'surat_kesediaan_id' => $pengajuan->surat_id,
            ]
        );

        return back()->with('success', 'Surat kesediaan berhasil divalidasi dan data telah diteruskan ke pendaftaran seminar dengan status Menunggu.');
    }

    public function quickValidateSeminar(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->update([
            'is_kesediaan_valid' => true,
        ]);

        // Teruskan data ke tabel skripsi
        Skripsi::updateOrCreate(
            ['nim' => $seminar->nim],
            [
                'judul' => $seminar->judul,
                'pembimbing1_id' => $seminar->pembimbing1_id,
                'pembimbing2_id' => $seminar->pembimbing2_id,
                'status' => 'menunggu',
                'pengajuan_judul_id' => $seminar->pengajuan_judul_id,
            ]
        );

        return back()->with('success', 'Surat kesediaan seminar berhasil divalidasi dan data telah diteruskan ke pendaftaran skripsi dengan status Menunggu.');
    }

    public function notifyJudul($id)
    {
        try {
            $pengajuan = PengajuanJudul::with('mahasiswa')->findOrFail($id);
            $mahasiswa = $pengajuan->mahasiswa;

            if (!$mahasiswa || !$mahasiswa->no_hp) {
                return response()->json(['success' => false, 'message' => 'Nomor HP mahasiswa tidak ditemukan.']);
            }

            $hour = now()->format('H');
            $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));

            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". Pengajuan judul skripsi Anda dengan judul: \"{$pengajuan->judul}\" telah DISETUJUI. Surat Kesediaan Bimbingan sudah dapat diunduh di sistem. Terima Kasih.";

            $waService = new \App\Services\WhatsAppService();
            $result = $waService->sendMessage($mahasiswa->no_hp, $message);

            if ($result && isset($result['status']) && $result['status'] == true) {
                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal mengirim pesan melalui Gateway.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroyPengajuanJudul($id)
    {
        $user = auth()->user();
        if (!$user->hasRole('staff') && !$user->hasRole('kaprodi')) {
            return back()->with('error', 'Akses ditolak.');
        }

        try {
            $pengajuan = PengajuanJudul::findOrFail($id);
            $pengajuan->delete();
            return redirect()->route('portal.riwayatPengajuanJudul')->with('success', 'Data pengajuan judul berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function editPengajuanJudul($id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);
        return response()->json($pengajuan);
    }

    public function updatePengajuanJudul(Request $request, $id)
    {
        $pengajuan = PengajuanJudul::findOrFail($id);
        $user = auth()->user();
        $isStaff = $user->hasRole('staff') || $user->hasRole('kaprodi');

        // Students can only edit if still pending
        if (!$isStaff && $pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'bukti_bayar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $path = $request->file('bukti_bayar')->store('bukti_bayar_judul', 'public');
            $validated['bukti_bayar'] = $path;
        }

        try {
            $pengajuan->update($validated);
            return redirect()->route('portal.riwayatPengajuanJudul')->with('success', 'Data pengajuan judul berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function downloadSuratKesediaan($id)
    {
        $pengajuan = PengajuanJudul::with(['mahasiswa.programStudi', 'pembimbing1', 'pembimbing2', 'surat'])->findOrFail($id);

        if ($pengajuan->status !== 'disetujui' || (!$pengajuan->surat_kesediaan && !$pengajuan->surat_id)) {
            return back()->with('error', 'Surat kesediaan belum tersedia.');
        }

        $mahasiswa = $pengajuan->mahasiswa;
        $prodi = $mahasiswa->programStudi;

        $data = [
            'pengajuan' => $pengajuan,
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
            'surat' => $pengajuan->surat, // Use the linked surat object
            'with_signature' => true,
            'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
            'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
            'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-kesediaan-bimbingan', $data);
        $filename = 'surat_kesediaan_' . $pengajuan->nim . '.pdf';

        return $pdf->stream($filename);
    }

    public function riwayatSeminar(Request $request)
    {
        $user = auth()->user();
        $query = Seminar::with(['mahasiswa', 'pembimbing1', 'pembimbing2', 'pengujiSeminar']);
        $notifications = $this->getNotifications();

        if ($user->hasRole('mahasiswa')) {
            $query->where('nim', $user->nim);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('acc_seminar', $request->status);
        }
        $seminars = $query->latest()->paginate(10)->withQueryString();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        return view('portal.riwayat-seminar', compact('seminars', 'notifications', 'dosens'));
    }

    public function riwayatSkripsi(Request $request)
    {
        $user = auth()->user();
        $query = Skripsi::with(['mahasiswa', 'pembimbing1', 'pembimbing2', 'penguji1', 'penguji2']);
        $notifications = $this->getNotifications();

        if ($user->hasRole('mahasiswa')) {
            $query->where('nim', $user->nim);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
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

        if ($user->hasRole('mahasiswa')) {
            $query->where('nim', $user->nim);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lokasi', 'like', "%{$search}%")->orWhere('laporan', 'like', "%{$search}%")
                    ->orWhereHas('mahasiswa', function ($mq) use ($search) {
                        $mq->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                    });
            });
        }
        $prakteks = $query->latest()->paginate(10)->withQueryString();
        $dosens = \App\Models\Dosen::orderBy('nama')->get();
        return view('portal.riwayat-prakteklapang', compact('prakteks', 'notifications', 'dosens'));
    }

    public function riwayatSurat(Request $request)
    {
        $user = auth()->user();
        $notifications = $this->getNotifications();

        $query = Surat::with(['seminars.mahasiswa', 'skripsis.mahasiswa', 'praktekLapangs.mahasiswa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_surat', 'like', "%{$search}%")
                    ->orWhere('jenis_surat', 'like', "%{$search}%")
                    ->orWhere('tujuan_surat', 'like', "%{$search}%");
            });
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        // Data for the "Buat Surat" modal
        $seminars = Seminar::with('mahasiswa')->whereNull('surat_undangan_id')->get();
        $skripsis = Skripsi::with('mahasiswa')->whereNull('surat_undangan_id')->get();
        $prakteks = PraktekLapang::with('mahasiswa')->whereNull('surat_id')->get();

        return view('portal.riwayat-surat', compact('surats', 'notifications', 'seminars', 'skripsis', 'prakteks'));
    }

    public function storeSurat(Request $request)
    {
        $validated = $request->validate([
            'jenis_surat' => 'required|string',
            'no_surat' => 'required|string|unique:surats,no_surat',
            'tujuan_surat' => 'required|string',
            'related_type' => 'nullable|in:seminar,skripsi,praktek_lapang',
            'related_id' => 'nullable|integer',
        ]);

        try {
            $surat = Surat::create([
                'jenis_surat' => $validated['jenis_surat'],
                'no_surat' => $validated['no_surat'],
                'tujuan_surat' => $validated['tujuan_surat'],
            ]);

            if ($request->filled('related_type') && $request->filled('related_id')) {
                if ($validated['related_type'] === 'seminar') {
                    Seminar::where('id', $validated['related_id'])->update(['surat_undangan_id' => $surat->id]);
                } elseif ($validated['related_type'] === 'skripsi') {
                    Skripsi::where('id', $validated['related_id'])->update(['surat_undangan_id' => $surat->id]);
                } elseif ($validated['related_type'] === 'praktek_lapang') {
                    PraktekLapang::where('id', $validated['related_id'])->update(['surat_id' => $surat->id]);
                }
            }

            return redirect()->route('portal.riwayatSurat')->with('success', 'Surat berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat surat: ' . $e->getMessage())->withInput();
        }
    }

    public function viewSurat($id)
    {
        $surat = Surat::with(['seminars.mahasiswa.programStudi', 'skripsis.mahasiswa.programStudi', 'praktekLapangs.mahasiswa.programStudi'])->findOrFail($id);

        $related_data = null;
        $prodi = null;

        if ($surat->seminars->isNotEmpty()) {
            $seminar = $surat->seminars->first();
            $related_data = [
                'mahasiswa' => $seminar->mahasiswa,
                'judul' => $seminar->judul,
                'tanggal' => $seminar->tanggal,
                'tempat' => $seminar->tempat,
            ];
            $prodi = $seminar->mahasiswa->programStudi;
        } elseif ($surat->skripsis->isNotEmpty()) {
            $skripsi = $surat->skripsis->first();
            $related_data = [
                'mahasiswa' => $skripsi->mahasiswa,
                'judul' => $skripsi->judul,
                'tanggal' => $skripsi->tanggal,
                'tempat' => $skripsi->tempat,
            ];
            $prodi = $skripsi->mahasiswa->programStudi;
        } elseif ($surat->praktekLapangs->isNotEmpty()) {
            $pl = $surat->praktekLapangs->first();
            $related_data = [
                'mahasiswa' => $pl->mahasiswa,
                'lokasi' => $pl->lokasi,
            ];
            $prodi = $pl->mahasiswa->programStudi;
        }

        $data = [
            'surat' => $surat,
            'related_data' => $related_data,
            'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
            'ketua_nama' => $prodi?->ketuaProdi?->nama ?? null,
            'ketua_nip' => $prodi?->ketuaProdi?->nidn ?? null,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.generic-surat', $data);
        $filename = 'surat_' . str_replace(['/', ' '], '_', $surat->no_surat) . '.pdf';

        return $pdf->stream($filename);
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
        if (!$user)
            return [];

        $items = [];
        $recentThreshold = now()->subDays(3);

        if ($user->hasRole('mahasiswa')) {
            // Notifications for status change (detected by updated_at > created_at within threshold)
            $seminarCount = Seminar::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($seminarCount > 0)
                $items[] = "Status Seminar Anda telah diperbarui.";

            $skripsiCount = Skripsi::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($skripsiCount > 0)
                $items[] = "Status pendaftaran Skripsi Anda telah diperbarui.";

            $praktekCount = PraktekLapang::where('nim', $user->nim)
                ->where('updated_at', '>=', $recentThreshold)
                ->whereColumn('updated_at', '>', 'created_at')
                ->count();
            if ($praktekCount > 0)
                $items[] = "Status Praktek Lapang Anda telah diperbarui.";
        }

        if ($user->hasRole('staff') || $user->hasRole('kaprodi')) {
            // Notifications for new data (penambahan data)
            $newSeminar = Seminar::where('created_at', '>=', $recentThreshold)->count();
            $newSkripsi = Skripsi::where('created_at', '>=', $recentThreshold)->count();
            $newPraktek = PraktekLapang::where('created_at', '>=', $recentThreshold)->count();

            if ($newSeminar > 0)
                $items[] = "Ada $newSeminar pendaftaran Seminar baru.";
            if ($newSkripsi > 0)
                $items[] = "Ada $newSkripsi pendaftaran Skripsi baru.";
            if ($newPraktek > 0)
                $items[] = "Ada $newPraktek pendaftaran Praktek Lapang baru.";

            $newJudul = PengajuanJudul::where('created_at', '>=', $recentThreshold)->count();
            if ($newJudul > 0)
                $items[] = "Ada $newJudul pengajuan Judul baru.";
        }

        if ($user->hasRole('dosen')) {
            $dosen = $user->dosen;
            if ($dosen) {
                $dosenId = $dosen->id;
                // Penambahan data where NIDN used (assigned as supervisor/examiner)
                $newSeminar = Seminar::where('created_at', '>=', $recentThreshold)
                    ->where(function ($q) use ($dosenId) {
                        $q->where('pembimbing1_id', $dosenId)->orWhere('pembimbing2_id', $dosenId)
                            ->orWhere('penguji_seminar_id', $dosenId)->orWhere('penguji2_id', $dosenId);
                    })->count();

                $newSkripsi = Skripsi::where('created_at', '>=', $recentThreshold)
                    ->where(function ($q) use ($dosenId) {
                        $q->where('pembimbing1_id', $dosenId)->orWhere('pembimbing2_id', $dosenId)
                            ->orWhere('penguji1_id', $dosenId)->orWhere('penguji2_id', $dosenId);
                    })->count();

                $newPraktek = PraktekLapang::where('created_at', '>=', $recentThreshold)
                    ->where('dosen_pembimbing_id', $dosenId)->count();

                if ($newSeminar > 0)
                    $items[] = "Anda ditunjuk sebagai pembimbing/penguji di $newSeminar Seminar baru.";
                if ($newSkripsi > 0)
                    $items[] = "Anda ditunjuk sebagai pembimbing/penguji di $newSkripsi Skripsi baru.";
                if ($newPraktek > 0)
                    $items[] = "Anda menjadi pembimbing di $newPraktek Praktek Lapang baru.";
            }
        }

        return $items;
    }

    public function downloadKesediaanSkripsi($id)
    {
        $skripsi = Skripsi::with(['mahasiswa.programStudi', 'pembimbing1', 'pembimbing2', 'penguji1', 'penguji2'])->findOrFail($id);

        if (!$skripsi->surat_kesediaan_id) {
            return back()->with('error', 'Surat kesediaan belum digenerate oleh staff.');
        }

        $mahasiswa = $skripsi->mahasiswa;
        $prodi = $mahasiswa->programStudi;
        $surat = $skripsi->suratKesediaan;

        $data = [
            'skripsi' => $skripsi,
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
            'surat' => $surat,
            'with_signature' => true,
            'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
            'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
            'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-kesediaan-sidang', $data);
        return $pdf->download('surat_kesediaan_sidang_' . $skripsi->nim . '.pdf');
    }

    public function uploadKesediaanSkripsi(Request $request, $id)
    {
        $request->validate([
            'file_kesediaan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $skripsi = Skripsi::findOrFail($id);

        if ($request->hasFile('file_kesediaan')) {
            $path = $request->file('file_kesediaan')->store('skripsi/kesediaan', 'public');
            $skripsi->update([
                'file_kesediaan' => $path,
                'is_kesediaan_valid' => false, // Reset validation if re-uploaded
            ]);

            return back()->with('success', 'Surat kesediaan berhasil diunggah. Silakan tunggu validasi dari Staff.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    public function downloadUndanganSkripsi($id)
    {
        $skripsi = Skripsi::with(['mahasiswa.programStudi', 'pembimbing1', 'pembimbing2', 'penguji1', 'penguji2'])->findOrFail($id);

        if (!$skripsi->is_kesediaan_valid || !$skripsi->surat_undangan_id) {
            return back()->with('error', 'Surat undangan belum tersedia atau kesediaan belum divalidasi.');
        }

        $mahasiswa = $skripsi->mahasiswa;
        $prodi = $mahasiswa->programStudi;
        $surat = $skripsi->suratUndangan;

        $data = [
            'skripsi' => $skripsi,
            'mahasiswa' => $mahasiswa,
            'surat' => $surat,
            'with_signature' => true,
            'ttd_path' => $prodi->ttd_ketua_prodi,
            'ketua_nama' => $prodi->ketuaProdi?->nama,
            'ketua_nip' => $prodi->ketuaProdi?->nidn,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-undangan-sidang', $data);
        return $pdf->download('surat_undangan_sidang_' . $skripsi->nim . '.pdf');
    }

    public function sendSkripsiNotification(Request $request, $id)
    {
        $skripsi = Skripsi::with('mahasiswa')->findOrFail($id);
        $message = $request->input('message');

        \App\Jobs\SendWhatsAppNotification::dispatch($skripsi, 'skripsi', $message);

        return back()->with('success', 'Notifikasi WhatsApp sedang dikirim.');
    }

    public function quickValidateSkripsi(Request $request, $id)
    {
        $skripsi = Skripsi::findOrFail($id);
        $skripsi->update([
            'is_kesediaan_valid' => true,
        ]);

        return back()->with('success', 'Surat kesediaan sidang skripsi berhasil divalidasi.');
    }
}
