@extends('layouts.app')

@section('title', 'Riwayat Skripsi')

@section('topbar-nav')
    <a href="#">Home</a>
    <a href="{{ route('portal.riwayatSkripsi') }}" class="active">Riwayat</a>
    <a href="#">Jadwal</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
        <div>
            <div class="section-label" style="display: inline-block; margin-bottom: 12px; padding: 2px 10px;">PORTAL AKADEMIK</div>
            <h1 class="page-title">Riwayat <span>Skripsi</span></h1>
            <p class="page-desc">Kelola dan pantau seluruh pengajuan skripsi Anda. Di sini Anda dapat melihat status persetujuan, jadwal, dan mengunduh berita acara resmi.</p>
        </div>
        <div>
            <a href="{{ route('portal.skripsi') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah skripsi baru
            </a>
        </div>
    </div>

    {{-- ── Filter & Search Section ── --}}
    <form action="{{ route('portal.riwayatSkripsi') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul skripsi atau nama mahasiswa..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 10px 24px;">Cari</button>
        </div>
        <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">STATUS PENGAJUAN</div>
            <select name="status" class="form-control form-select" style="padding: 6px 12px; border: none;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
    </form>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">No</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Identitas & Judul</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Waktu & Sidang</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Dosen (Pembimbing & Penguji)</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Syarat</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Status</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tanggal Pengajuan</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($skripsis as $skripsi)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $loop->iteration }}</div>
                            </td>
                            <td style="padding: 16px 24px; max-width: 320px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $skripsi->mahasiswa->nama ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 8px;">{{ $skripsi->nim }} • {{ $skripsi->mahasiswa->prodi->nama ?? '' }}</div>
                                <p style="font-size: 12px; font-weight: 600; color: var(--brand-dark); line-height: 1.4; font-style: italic;">"{{ $skripsi->judul }}"</p>
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($skripsi->tanggal)
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text-primary);">{{ $skripsi->tanggal->format('d M Y') }}</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">{{ $skripsi->waktu ?? '09:00' }} WIB</div>
                                    <div style="margin-top: 8px; font-size: 10px; font-weight: 700; color: var(--accent); display: flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $skripsi->tempat ?? 'TBA' }}
                                    </div>
                                @else
                                    <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Jadwal</div>
                                @endif
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div>
                                        <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing</div>
                                        <div style="font-size: 11px; font-weight: 600;">1. {{ $skripsi->pembimbing1->nama ?? '-' }}</div>
                                        <div style="font-size: 11px; font-weight: 600;">2. {{ $skripsi->pembimbing2->nama ?? '-' }}</div>
                                    </div>
                                    <div>
                                        <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Tim Penguji</div>
                                        <div style="font-size: 11px; font-weight: 600;">1. {{ $skripsi->penguji1->nama ?? '-' }}</div>
                                        <div style="font-size: 11px; font-weight: 600;">2. {{ $skripsi->penguji2->nama ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 24px; vertical-align: middle;">
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    @php
                                        $files = [
                                            ['label' => 'Bukti Bayar', 'path' => $skripsi->bukti_bayar],
                                            ['label' => 'Transkrip', 'path' => $skripsi->transkrip_nilai],
                                            ['label' => 'TOEFL', 'path' => $skripsi->toefl],
                                        ];
                                    @endphp
                                    
                                    @foreach($files as $file)
                                        @if($file['path'])
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="badge" style="background: #D1FAE5; color: #065F46; text-decoration: none; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 9px; width: fit-content;">
                                                {{ $file['label'] }}: OK
                                            </a>
                                        @else
                                            <span class="badge" style="background: #FEE2E2; color: #991B1B; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 9px; width: fit-content;">
                                                {{ $file['label'] }}
                                            </span>
                                        @endif
                                    @endforeach

                                    @if($skripsi->file_kesediaan)
                                        <a href="{{ asset('storage/' . $skripsi->file_kesediaan) }}" target="_blank" class="badge" style="background: {{ $skripsi->is_kesediaan_valid ? '#D1FAE5' : '#FEF3C7' }}; color: {{ $skripsi->is_kesediaan_valid ? '#065F46' : '#92400E' }}; text-decoration: none; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 9px; width: fit-content;">
                                            Kesediaan: {{ $skripsi->is_kesediaan_valid ? 'Valid' : 'Pending' }}
                                        </a>
                                    @else
                                        <span class="badge" style="background: #f3f4f6; color: #6b7280; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 9px; width: fit-content;">
                                            Kesediaan
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 16px 24px;">
                                @php
                                    $status = strtolower($skripsi->status ?? 'menunggu');
                                    $badgeStyle = match($status) {
                                        'disetujui' => 'background: #D1FAE5; color: #065F46;',
                                        'ditolak' => 'background: #FEE2E2; color: #991B1B;',
                                        default => 'background: #CDFAF3; color: #007A6E;',
                                    };
                                    $dotStyle = match($status) {
                                        'disetujui', 'ditolak' => '',
                                        default => 'animation: pulse 2s infinite;',
                                    };
                                @endphp
                                <span class="badge" style="{{ $badgeStyle }}">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor; {{ $dotStyle }}"></span>
                                    {{ strtoupper($status) }}
                                </span>
                            </td>
                            <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                                {{ $skripsi->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 16px 24px; text-align: right;">
                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 8px;">
                                    <div style="display: flex; gap: 8px;">
                                        @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('kaprodi'))
                                            {{-- WhatsApp Notification --}}
                                            @php
                                                $hour = now()->format('H');
                                                $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));
                                                $brandText = "kami dari Fakultas Pertanian, Sains dan Teknologi Universitas Panca Bhakti Pontianak.";
                                                $mahasiswaNama = $skripsi->mahasiswa->nama ?? '';
                                                
                                                if ($skripsi->canDownloadUndangan()) {
                                                    $waMsg = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Undangan sidang skripsi sudah dapat didownload pada sistem informasi. Terima Kasih.";
                                                } elseif ($skripsi->file_kesediaan) {
                                                    $waMsg = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Kesediaan Sidang sedang divalidasi. Mohon cek berkala. Terima Kasih.";
                                                } elseif ($skripsi->canDownloadKesediaan()) {
                                                    $waMsg = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Kesediaan Sidang sudah dapat diunduh. Silakan ttd dosen pembimbing & penguji, lalu unggah kembali. Terima Kasih.";
                                                } else {
                                                    $waMsg = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Pendaftaran skripsi Anda sedang diproses. Mohon lengkapi berkas. Terima Kasih.";
                                                }
                                            @endphp
                                            <button type="button" class="topbar-icon-btn" onclick="openWaModal({{ $skripsi->id }}, '{{ $skripsi->mahasiswa->no_hp ?? '' }}', '{{ addslashes($waMsg) }}')" title="Kirim Notifikasi WA" style="color: #25D366; border:none; background:none; cursor:pointer;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3.5l-1.5 5.5Z"></path></svg>
                                            </button>

                                            <button type="button" class="topbar-icon-btn" onclick="editSkripsi({{ $skripsi->id }})" title="Edit Data" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>

                                            @if($skripsi->file_kesediaan && !$skripsi->is_kesediaan_valid)
                                                <button type="button" class="topbar-icon-btn" onclick="quickValidate({{ $skripsi->id }})" title="Validasi Cepat Surat Kesediaan" style="color: #6366F1; border:none; background:none; cursor:pointer;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                </button>
                                            @endif
                                            
                                            <form action="{{ route('portal.skripsi.destroy', $skripsi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="topbar-icon-btn" title="Hapus Data" style="color: #EF4444; border:none; background:none; cursor:pointer;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                </button>
                                            </form>
                                        @elseif(auth()->user()->hasRole('mahasiswa') && !$skripsi->is_kesediaan_valid)
                                            <button type="button" class="topbar-icon-btn" onclick="editSkripsi({{ $skripsi->id }})" title="Update Berkas" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>
                                        @endif
                                    </div>

                                    @if($skripsi->is_kesediaan_valid)
                                        <a href="{{ route('portal.skripsi.undangan', $skripsi->id) }}" target="_blank" class="btn btn-sm" style="background: #6366F1; color: #fff; text-decoration: none; border-radius: 8px; padding: 8px 12px; font-weight: 700; font-size: 10px; text-transform: uppercase;">
                                            Surat Undangan
                                        </a>
                                    @else
                                        <div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
                                            @if($skripsi->canDownloadKesediaan())
                                                <div style="margin-bottom: 2px; font-size: 9px; color: var(--brand); font-weight: 700; text-transform: uppercase; text-align: right;">Tahap 1: TTD Kesediaan</div>
                                                <a href="{{ route('portal.skripsi.kesediaan', $skripsi->id) }}" target="_blank" class="btn btn-sm" style="background: #fff; color: var(--brand); border: 1.5px solid var(--brand); font-size: 9px; padding: 6px 10px; font-weight: 800; text-transform: uppercase; border-radius: 6px;">
                                                    Download Kesediaan
                                                </a>
                                                <button type="button" onclick="openUploadModal({{ $skripsi->id }})" class="btn btn-sm btn-primary" style="font-size: 9px; padding: 6px 10px; font-weight: 800; text-transform: uppercase; border-radius: 6px;">
                                                    Upload Kesediaan
                                                </button>
                                            @else
                                                <span style="font-size: 10px; color: var(--text-muted); font-style: italic; text-align: right;">Menunggu Jadwal/Penguji</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 48px; text-align: center; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    <span>Tidak ada data skripsi ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 16px 24px; background: var(--bg-page); display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 12px; color: var(--text-muted);">
                Menampilkan {{ $skripsis->firstItem() ?? 0 }} sampai {{ $skripsis->lastItem() ?? 0 }} dari {{ $skripsis->total() }} pengajuan
            </span>
            <div class="pagination-links">
                {{ $skripsis->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:flex-start; justify-content:center; overflow-y:auto; padding: 40px 16px;">
        <div class="card" style="width:100%; max-width:600px; padding:32px; background:var(--bg-card); margin: auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Edit Data Skripsi</h2>
                <button onclick="closeModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('kaprodi'))
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Judul Skripsi</label>
                    <textarea name="judul" id="edit_judul" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Pembimbing 1</label>
                        <select name="pembimbing1_id" id="edit_pembimbing1" class="form-control form-select" required>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pembimbing 2</label>
                        <select name="pembimbing2_id" id="edit_pembimbing2" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Penguji 1</label>
                        <select name="penguji1_id" id="edit_penguji1" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Penguji 2</label>
                        <select name="penguji2_id" id="edit_penguji2" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Tanggal Sidang</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tempat Sidang</label>
                        <input type="text" name="tempat" id="edit_tempat" class="form-control">
                    </div>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control form-select">
                            <option value="menunggu">Menunggu</option>
                            <option value="proses">Dalam Proses</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Surat Kesediaan</label>
                        <input type="text" name="no_surat_kesediaan" id="edit_no_surat_kesediaan" class="form-control" placeholder="Contoh: UN1/FP/SKR-001/2026">
                    </div>
                </div>
                @endif

                {{-- Digital Archives (Always visible for edit) --}}
                <div class="section-label" style="margin-top: 16px; margin-bottom: 24px;">UPDATE BERKAS (PDF/IMG)</div>
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Bukti Bayar</label>
                    <input type="file" name="bukti_bayar" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label">Transkrip Nilai</label>
                    <input type="file" name="transkrip_nilai" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Sertifikat TOEFL</label>
                    <input type="file" name="toefl" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- WhatsApp Preview Modal --}}
    <div id="waModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10001; align-items:center; justify-content:center;">
        <div class="card" style="width:100%; max-width:500px; padding:32px; background:var(--bg-card); position: relative;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 12px; background: #DCF8C6; color: #075E54; display: flex; align-items: center; justify-content: center;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3.5l-1.5 5.5Z"></path></svg>
                    </div>
                    <div>
                        <h2 style="font-size:16px; font-weight:700; margin: 0;">Pratinjau Pesan WA</h2>
                        <p style="font-size: 11px; color: var(--text-muted); margin: 0;">Kirim otomatis via Wablas Gateway</p>
                    </div>
                </div>
                <button onclick="closeWaModal()" style="border:none; background:none; cursor:pointer; font-size:24px; color: var(--text-muted);">&times;</button>
            </div>
            
            <div style="background: var(--bg-body); padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase;">Nomor Tujuan</div>
                <div id="wa_display_number" style="font-size: 14px; font-weight: 600; color: var(--brand); margin-bottom: 16px;"></div>
                
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase;">Isi Pesan</div>
                <div id="wa_display_message" style="font-size: 13px; line-height: 1.6; color: var(--text-primary); background: #fff; padding: 12px; border-radius: 8px; border: 1px solid var(--border); white-space: pre-wrap;"></div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; flex-wrap: wrap;">
                <button type="button" onclick="closeWaModal()" class="btn btn-secondary">Batal</button>
                <div style="display: flex; gap: 8px;">
                    <a id="btnManualWa" href="#" target="_blank" class="btn" style="background: #E5E7EB; color: #374151; border: none; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; font-size: 13px; padding: 8px 16px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        Kirim Manual
                    </a>
                    <button type="button" id="btnSendWa" class="btn btn-primary" style="background: #25D366; border: none; font-weight: 700; display: flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>
                        <span id="waBtnText">Kirim Otomatis</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Upload Kesediaan Modal --}}
    <div id="uploadKesediaanModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10002; align-items:flex-start; justify-content:center; overflow-y:auto; padding: 40px 16px;">
        <div class="card" style="width:100%; max-width:450px; padding:32px; background:var(--bg-card); position: relative; margin: auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2 style="font-size:18px; font-weight:700; margin: 0;">Upload Surat Kesediaan</h2>
                <button onclick="closeUploadModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Silakan unggah pindaian (scan) Surat Kesediaan Sidang yang telah ditandatangani.</p>
            <form id="uploadKesediaanForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">File Surat Kesediaan</label>
                    <input type="file" name="file_kesediaan" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeUploadModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filterSkripsiEditOptions() {
        const p1 = document.getElementById('edit_pembimbing1');
        const p2 = document.getElementById('edit_pembimbing2');
        const penguji1 = document.getElementById('edit_penguji1');
        const penguji2 = document.getElementById('edit_penguji2');
 
        if (!p1 || !p2 || !penguji1 || !penguji2) return;
 
        const selectors = [p1, p2, penguji1, penguji2];
        const values = selectors.map(s => s.value);

        selectors.forEach(select => {
            Array.from(select.options).forEach(opt => {
                if (opt.value === "") { opt.disabled = false; opt.style.display = 'block'; return; }
                opt.disabled = false;
                opt.style.display = 'block';
            });
        });

        selectors.forEach((select, index) => {
            const currentVal = values[index];
            if (currentVal && currentVal !== "") {
                selectors.forEach((otherSelect, otherIndex) => {
                    if (index !== otherIndex) {
                        const opt = Array.from(otherSelect.options).find(o => o.value === currentVal);
                        if (opt) { opt.disabled = true; opt.style.display = 'none'; }
                    }
                });
            }
        });
    }

    ['edit_pembimbing1', 'edit_pembimbing2', 'edit_penguji1', 'edit_penguji2'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.addEventListener('change', filterSkripsiEditOptions);
    });

    function editSkripsi(id) {
        fetch(`/portal/skripsi/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editForm');
                form.action = `/portal/skripsi/${id}`;
                
                if(document.getElementById('edit_judul')) document.getElementById('edit_judul').value = data.judul;
                if(document.getElementById('edit_pembimbing1')) document.getElementById('edit_pembimbing1').value = data.pembimbing1_id;
                if(document.getElementById('edit_pembimbing2')) document.getElementById('edit_pembimbing2').value = data.pembimbing2_id || '';
                if(document.getElementById('edit_penguji1')) document.getElementById('edit_penguji1').value = data.penguji1_id || '';
                if(document.getElementById('edit_penguji2')) document.getElementById('edit_penguji2').value = data.penguji2_id || '';
                
                filterSkripsiEditOptions();
 
                if(document.getElementById('edit_tanggal')) document.getElementById('edit_tanggal').value = data.tanggal ? data.tanggal.split('T')[0] : '';
                if(document.getElementById('edit_tempat')) document.getElementById('edit_tempat').value = data.tempat || '';
                if(document.getElementById('edit_status')) document.getElementById('edit_status').value = data.status || 'menunggu';
                if(document.getElementById('edit_no_surat_kesediaan')) document.getElementById('edit_no_surat_kesediaan').value = data.surat_kesediaan ? data.surat_kesediaan.no_surat : '';
                
                document.getElementById('editModal').style.display = 'flex';
            });
    }
 
    function quickValidate(id) {
        if (!confirm('Apakah Anda yakin ingin memvalidasi surat kesediaan ini? Surat Undangan akan otomatis digenerate.')) return;
 
        fetch(`/portal/skripsi/${id}/validate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Gagal memvalidasi surat kesediaan.');
            }
        });
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // WA Functions
    function openWaModal(id, phoneNumber, message) {
        document.getElementById('wa_display_number').innerText = phoneNumber || 'N/A';
        document.getElementById('wa_display_message').innerText = message;
        
        // Setup link manual
        const cleanNumber = (phoneNumber || '').replace(/\D/g, '');
        const waLink = `https://wa.me/${cleanNumber.startsWith('0') ? '62'+cleanNumber.substring(1) : cleanNumber}?text=${encodeURIComponent(message)}`;
        document.getElementById('btnManualWa').href = waLink;

        const btnSend = document.getElementById('btnSendWa');
        btnSend.onclick = () => sendWaNotification(id);
        
        document.getElementById('waModal').style.display = 'flex';
    }

    function closeWaModal() {
        document.getElementById('waModal').style.display = 'none';
        document.getElementById('waBtnText').innerText = 'Kirim Otomatis';
        document.getElementById('btnSendWa').disabled = false;
    }

    function sendWaNotification(id) {
        const btn = document.getElementById('btnSendWa');
        const btnText = document.getElementById('waBtnText');
        btn.disabled = true;
        btnText.innerText = 'Mengirim...';

        fetch(`/portal/skripsi/${id}/notify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ message: document.getElementById('wa_display_message').innerText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Notifikasi terkirim!');
                closeWaModal();
            } else {
                alert('Gagal: ' + (data.message || 'Error'));
                btn.disabled = false;
                btnText.innerText = 'Kirim Otomatis';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Kesalahan koneksi.');
            btn.disabled = false;
            btnText.innerText = 'Kirim Otomatis';
        });
    }

    function openUploadModal(id) {
        const form = document.getElementById('uploadKesediaanForm');
        form.action = `/portal/skripsi/${id}/kesediaan`;
        document.getElementById('uploadKesediaanModal').style.display = 'flex';
    }

    function closeUploadModal() {
        document.getElementById('uploadKesediaanModal').style.display = 'none';
    }
</script>
@endpush
@endsection
