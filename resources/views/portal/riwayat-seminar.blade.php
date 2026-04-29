@extends('layouts.app')

@section('title', 'Riwayat Seminar')

@section('topbar-nav')
    <a href="#">Home</a>
    <a href="{{ route('portal.riwayatSeminar') }}" class="active">Riwayat</a>
    <a href="#">Jadwal</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
        <div>
            <div class="section-label" style="display: inline-block; margin-bottom: 12px; padding: 2px 10px;">PORTAL AKADEMIK</div>
            <h1 class="page-title">Riwayat <span>Seminar</span></h1>
            <p class="page-desc">Kelola dan pantau seluruh pengajuan seminar Anda. Di sini Anda dapat melihat status persetujuan, jadwal, dan mengunduh berita acara resmi.</p>
        </div>
        <!-- <div>
            <a href="{{ route('portal.seminar') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah seminar baru
            </a>
        </div> -->
    </div>

    {{-- ── Filter & Search Section ── --}}
    <form action="{{ route('portal.riwayatSeminar') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul seminar atau nama pembimbing..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
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
        <!-- <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">PERIODE SEMESTER</div>
            <select class="form-control form-select" style="padding: 6px 12px; border: none;">
                <option>Ganjil 2023/2024</option>
                <option>Genap 2022/2023</option>
                <option>Ganjil 2022/2023</option>
            </select>
        </div> -->
    </form>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">No</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Identitas & Judul</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Waktu & Tanggal</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Dosen (Pembimbing & Penguji)</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Syarat</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Status</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tanggal Pengajuan</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Keterangan</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($seminars as $seminar)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 16px 24px; max-width: 320px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $loop->iteration }}</div>
                            </td>   
                            <td style="padding: 16px 24px; max-width: 320px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $seminar->mahasiswa->nama ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 8px;">{{ $seminar->nim }} • {{ $seminar->mahasiswa->prodi->nama ?? '' }}</div>
                                <p style="font-size: 13px; font-weight: 600; color: var(--brand-dark); line-height: 1.4;">{{ $seminar->judul }}</p>
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($seminar->tanggal)
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text-primary);">{{ $seminar->tanggal->format('d M Y') }}</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">{{ $seminar->waktu ?? '09:00 - 11:00' }} WIB</div>
                                    <div style="margin-top: 8px; font-size: 10px; font-weight: 700; color: var(--accent); display: flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $seminar->tempat ?? 'TBA' }}
                                    </div>
                                @else
                                    <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Jadwal</div>
                                @endif
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div>
                                        <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing</div>
                                        @if($seminar->pembimbing1)
                                            <div style="font-size: 11px; font-weight: 600;">1. {{ $seminar->pembimbing1->nama ?? '-' }}</div>    
                                            @else
                                            <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Pembimbing</div>
                                        @endif
                                        @if($seminar->pembimbing2)
                                            <div style="font-size: 11px; font-weight: 600;">2. {{ $seminar->pembimbing2->nama ?? '-' }}</div>
                                            @else
                                            <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Pembimbing</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Tim Penguji</div>
                                        @if($seminar->pengujiSeminar)
                                            <div style="font-size: 11px; font-weight: 600;">{{ $seminar->pengujiSeminar->nama ?? '-' }}</div>
                                            @else
                                            <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Penguji</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 24px; vertical-align: middle;">
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    @if($seminar->bukti_bayar)
                                        <a href="{{ asset('storage/' . $seminar->bukti_bayar) }}" target="_blank" class="badge" style="background: #D1FAE5; color: #065F46; text-decoration: none; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 10px; width: fit-content;">
                                            Bukti Bayar
                                        </a>
                                    @else
                                        <span class="badge" style="background: #FEE2E2; color: #991B1B; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 10px; width: fit-content;">
                                            Bukti Bayar
                                        </span>
                                    @endif

                                    @if($seminar->file_kesediaan)
                                        <a href="{{ asset('storage/' . $seminar->file_kesediaan) }}" target="_blank" class="badge" style="background: {{ $seminar->is_kesediaan_valid ? '#D1FAE5' : '#FEF3C7' }}; color: {{ $seminar->is_kesediaan_valid ? '#065F46' : '#92400E' }}; text-decoration: none; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 10px; width: fit-content;">
                                            @if(auth()->user()->hasAnyRole(['admin', 'staff', 'kaprodi']))
                                                Kesediaan: {{ $seminar->is_kesediaan_valid ? 'Valid' : 'Lihat Doc' }}
                                            @else
                                                Kesediaan: {{ $seminar->is_kesediaan_valid ? 'Valid' : 'Pending' }}
                                            @endif
                                        </a>
                                    @else
                                        <span class="badge" style="background: #f3f4f6; color: #6b7280; border-radius: 6px; padding: 4px 10px; font-weight: 700; font-size: 10px; width: fit-content;">
                                            Kesediaan: Belum Upload
                                        </span>
                                    @endif

                                    @if($seminar->suratKesediaan)
                                        <div style="font-size: 9px; color: var(--text-muted); margin-top: 2px;">
                                            No: {{ $seminar->suratKesediaan->no_surat }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($seminar->acc_seminar == 'Disetujui')
                                    <span class="badge badge-green">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        Disetujui
                                    </span>
                                @elseif($seminar->acc_seminar == 'Ditolak')
                                    <span class="badge badge-red" style="background: #FEE2E2; color: #991B1B;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge" style="background: #CDFAF3; color: #007A6E;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: pulse 2s infinite;"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                                {{ $seminar->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 16px 24px; font-size: 12px; color: var(--text-secondary); max-width: 200px;">
                                {{ $seminar->keterangan ?? '-' }}
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
                                                $mahasiswaNama = $seminar->mahasiswa->nama ?? '';

                                                if ($seminar->canGenerateSurat()) {
                                                    $waMessage = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Undangan seminar sudah dapat didownload pada sistem informasi FPST UPB. Terima Kasih.";
                                                } elseif ($seminar->file_kesediaan) {
                                                    $waMessage = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Kesediaan Seminar Anda sedang divalidasi. Mohon cek berkala untuk mengunduh Surat Undangan Seminar jika sudah disetujui. Terima Kasih.";
                                                } elseif ($seminar->canDownloadKesediaan()) {
                                                    $waMessage = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Surat Kesediaan Seminar sudah dapat diunduh di sistem. Silakan diprint dan dimintakan tanda tangan dosen pembimbing, lalu unggah kembali scan surat tersebut ke portal. Terima Kasih.";
                                                } else {
                                                    $waMessage = "Selamat {$greeting} {$mahasiswaNama}. {$brandText} Pendaftaran seminar Anda sedang dalam proses verifikasi staff. Terima Kasih.";
                                                }
                                            @endphp
                                            <button type="button" class="topbar-icon-btn" onclick="openWaModal({{ $seminar->id }}, '{{ $seminar->mahasiswa->no_hp ?? '' }}', '{{ addslashes($waMessage) }}')" title="Kirim Notifikasi WA (Wablas)" style="color: #25D366; border:none; background:none; cursor:pointer; display: flex; align-items: center; justify-content: center;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3.5l-1.5 5.5Z"></path></svg>
                                            </button>

                                            <button type="button" class="topbar-icon-btn" onclick="editSeminar({{ $seminar->id }})" title="Edit Data" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </button>
                                            
                                            @if($seminar->file_kesediaan && !$seminar->is_kesediaan_valid)
                                                <button type="button" class="topbar-icon-btn" onclick="quickValidate({{ $seminar->id }})" title="Validasi Cepat Surat Kesediaan" style="color: #6366F1; border:none; background:none; cursor:pointer;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                </button>
                                            @endif

                                            <form action="{{ route('portal.seminar.destroy', $seminar->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="topbar-icon-btn" title="Hapus Data" style="color: #EF4444; border:none; background:none; cursor:pointer;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    {{-- Tombol untuk Mahasiswa: Upload Bukti Bayar --}}
                                    @if(auth()->user()->hasRole('mahasiswa') && $seminar->acc_seminar === 'Menunggu')
                                        <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-end; margin-top: 4px;">
                                            @if($seminar->bukti_bayar)
                                                <span style="font-size: 9px; color: #059669; font-weight: 700; text-transform: uppercase;">✓ Bukti Bayar Terunggah</span>
                                            @else
                                                <button type="button"
                                                    onclick="openUploadBuktiBayarModal({{ $seminar->id }})"
                                                    class="btn btn-sm btn-primary"
                                                    style="font-size: 9px; padding: 6px 12px; font-weight: 800; text-transform: uppercase; border-radius: 6px; white-space: nowrap;">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                                    Upload Bukti Bayar
                                                </button>
                                            @endif
                                        </div>
                                    @endif

                                    @if($seminar->canGenerateSurat())
                                        <!-- <div style="margin-bottom: 4px; font-size: 9px; color: #059669; font-weight: 700; text-transform: uppercase;">Undangan Siap:</div> -->
                                        <a href="{{ route('portal.seminar.undangan', $seminar->id) }}" target="_blank" class="btn btn-sm" style="background: #6366F1; color: #fff; text-decoration: none; border-radius: 8px; padding: 8px 12px; font-weight: 700; font-size: 10px; text-transform: uppercase; white-space: nowrap; border: none; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);">
                                            Surat Undangan
                                        </a>
                                    @else
                                        <div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
                                            @if($seminar->canDownloadKesediaan())
                                                @if(!$seminar->file_kesediaan)
                                                    <div style="margin-bottom: 2px; font-size: 9px; color: var(--brand); font-weight: 700; text-transform: uppercase;">Tahap 1: TTD Kesediaan</div>
                                                    <a href="{{ route('portal.seminar.kesediaan', $seminar->id) }}" target="_blank" class="btn btn-sm" style="background: #fff; color: var(--brand); border: 1.5px solid var(--brand); font-size: 9px; padding: 6px 10px; font-weight: 800; text-transform: uppercase; border-radius: 6px; text-align: center;">
                                                        Download Kesediaan
                                                    </a>
                                                    <button type="button" onclick="openUploadModal({{ $seminar->id }})" class="btn btn-sm btn-primary" style="font-size: 9px; padding: 6px 10px; font-weight: 800; text-transform: uppercase; border-radius: 6px; text-align: center;">
                                                        Upload Kesediaan
                                                    </button>
                                                @else
                                                    @if(!$seminar->is_kesediaan_valid)
                                                        <div style="margin-bottom: 2px; font-size: 9px; color: #D97706; font-weight: 700; text-transform: uppercase;">Tahap 2: Validasi Staff</div>
                                                        <span style="font-size: 10px; color: var(--text-muted); background: #FEF3C7; padding: 4px 8px; border-radius: 4px; text-align: center;">Menunggu Validasi Kesediaan</span>
                                                        <button type="button" onclick="openUploadModal({{ $seminar->id }})" class="btn btn-sm" style="font-size: 8px; color: var(--brand); text-decoration: underline; border: none; background: transparent;">Unggah Ulang?</button>
                                                    @endif
                                                @endif
                                            @else
                                                <!-- <div style="font-size: 9px; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Tahap 0: Plotting</div> -->
                                                <span style="font-size: 10px; color: var(--text-muted); font-style: italic; text-align: center;">Menunggu Penguji</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    <span>Tidak ada data seminar ditemukan</span>
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
                Menampilkan {{ $seminars->firstItem() ?? 0 }} sampai {{ $seminars->lastItem() ?? 0 }} dari {{ $seminars->total() }} pengajuan
            </span>
            <div class="pagination-links">
                {{ $seminars->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:flex-start; justify-content:center; overflow-y:auto; padding: 40px 16px;">
        <div class="card" style="width:100%; max-width:600px; padding:32px; background:var(--bg-card); margin: auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Edit Data Seminar</h2>
                <button onclick="closeModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Judul Seminar</label>
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
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tempat</label>
                        <input type="text" name="tempat" id="edit_tempat" class="form-control">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">Penguji Seminar</label>
                    <select name="penguji_seminar_id" id="edit_penguji_seminar" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Status Persetujuan</label>
                        <select name="acc_seminar" id="edit_status" class="form-control form-select">
                            <option value="Menunggu">Menunggu</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" name="is_kesediaan_valid" id="edit_is_kesediaan_valid" value="1" style="width: 16px; height: 16px;">
                            Validasi Surat Kesediaan
                        </label>
                        <div id="kesediaan_file_status" style="margin-top: 8px; font-size: 11px;"></div>
                    </div>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:24px;">
                    <div class="form-group">
                        <label class="form-label">Update Bukti Bayar (PDF/JPG)</label>
                        <input type="file" name="bukti_bayar" class="form-control">
                        <div id="current_file_status" style="margin-top: 8px; font-size: 11px;"></div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">Keterangan / Pesan untuk Mahasiswa</label>
                    <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2" placeholder="Masukkan catatan atau pesan untuk mahasiswa..."></textarea>
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
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Nomor Tujuan</div>
                <div id="wa_display_number" style="font-size: 14px; font-weight: 600; color: var(--brand); margin-bottom: 16px;"></div>
                
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Isi Pesan</div>
                <div id="wa_display_message" style="font-size: 13px; line-height: 1.6; color: var(--text-primary); background: #fff; padding: 12px; border-radius: 8px; border: 1px solid var(--border); white-space: pre-wrap;"></div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:12px; flex-wrap: wrap;">
                <button type="button" onclick="closeWaModal()" class="btn btn-secondary">Batal</button>
                <div style="display: flex; gap: 8px;">
                    <a id="btnManualWa" href="#" target="_blank" class="btn" style="background: #E5E7EB; color: #374151; border: none; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
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
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Silakan unggah pindaian (scan) Surat Kesediaan Seminar yang telah ditandatangani oleh Dosen Pembimbing (Format: PDF/JPG/PNG).</p>
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

{{-- Upload Bukti Bayar Modal (Mahasiswa) --}}
<div id="uploadBuktiBayarModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10003; align-items:flex-start; justify-content:center; overflow-y:auto; padding: 40px 16px;">
    <div class="card" style="width:100%; max-width:450px; padding:32px; background:var(--bg-card); position: relative; margin: auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h2 style="font-size:18px; font-weight:700; margin: 0;">Upload Bukti Bayar Seminar</h2>
                <p style="font-size:12px; color:var(--text-muted); margin: 4px 0 0;">Format: PDF, JPG, atau PNG. Maks. 5 MB.</p>
            </div>
            <button onclick="closeUploadBuktiBayarModal()" style="border:none; background:none; cursor:pointer; font-size:24px; color:var(--text-muted);">&times;</button>
        </div>
        <form id="uploadBuktiBayarForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">File Bukti Pembayaran</label>
                <input type="file" name="bukti_bayar" id="input_bukti_bayar" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                <div style="margin-top: 8px; font-size: 11px; color: var(--text-muted);">Unggah bukti transfer / slip pembayaran seminar Anda.</div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" onclick="closeUploadBuktiBayarModal()" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Unggah Sekarang
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function filterEditOptions() {
        const p1 = document.getElementById('edit_pembimbing1');
        const p2 = document.getElementById('edit_pembimbing2');
        const penguji = document.getElementById('edit_penguji_seminar');

        const val1 = p1.value;
        const val2 = p2.value;
        const valPenguji = penguji.value;

        [p1, p2, penguji].forEach(select => {
            Array.from(select.options).forEach(opt => {
                if (opt.value === "") { opt.disabled = false; opt.style.display = 'block'; return; }
                opt.disabled = false;
                opt.style.display = 'block';
            });
        });

        if (val1) {
            [p2, penguji].forEach(s => {
                const opt = Array.from(s.options).find(o => o.value === val1);
                if (opt) { opt.disabled = true; opt.style.display = 'none'; }
            });
        }
        if (val2) {
            [p1, penguji].forEach(s => {
                const opt = Array.from(s.options).find(o => o.value === val2);
                if (opt) { opt.disabled = true; opt.style.display = 'none'; }
            });
        }
        if (valPenguji) {
            [p1, p2].forEach(s => {
                const opt = Array.from(s.options).find(o => o.value === valPenguji);
                if (opt) { opt.disabled = true; opt.style.display = 'none'; }
            });
        }
    }

    document.getElementById('edit_pembimbing1').addEventListener('change', filterEditOptions);
    document.getElementById('edit_pembimbing2').addEventListener('change', filterEditOptions);
    document.getElementById('edit_penguji_seminar').addEventListener('change', filterEditOptions);

    function editSeminar(id) {
        fetch(`/portal/seminar/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editForm');
                form.action = `/portal/seminar/${id}`;
                document.getElementById('edit_judul').value = data.judul;
                document.getElementById('edit_pembimbing1').value = data.pembimbing1_id;
                document.getElementById('edit_pembimbing2').value = data.pembimbing2_id || '';
                document.getElementById('edit_penguji_seminar').value = data.penguji_seminar_id || '';
                
                // After setting values, filter
                filterEditOptions();

                document.getElementById('edit_tanggal').value = data.tanggal ? data.tanggal.split('T')[0] : '';
                document.getElementById('edit_tempat').value = data.tempat || '';
                document.getElementById('edit_status').value = data.acc_seminar;
                document.getElementById('edit_is_kesediaan_valid').checked = !!data.is_kesediaan_valid;
                document.getElementById('edit_keterangan').value = data.keterangan || '';
                
                const fileStatus = document.getElementById('current_file_status');
                if (data.bukti_bayar) {
                    fileStatus.innerHTML = `<span style="color: #059669;">✔ Bukti bayar tersedia.</span> <a href="/storage/${data.bukti_bayar}" target="_blank" style="color: var(--brand); text-decoration: underline;">Lihat file</a>`;
                } else {
                    fileStatus.innerHTML = `<span style="color: #DC2626;">✘ Bukti bayar belum diupload.</span>`;
                }

                const kesediaanStatus = document.getElementById('kesediaan_file_status');
                if (data.file_kesediaan) {
                    kesediaanStatus.innerHTML = `<span style="color: #059669;">✔ Surat Kesediaan tersedia.</span> <a href="/storage/${data.file_kesediaan}" target="_blank" style="color: var(--brand); text-decoration: underline;">Lihat file</a>`;
                } else {
                    kesediaanStatus.innerHTML = `<span style="color: #6366f1;">ℹ Surat Kesediaan belum diupload mahasiswa.</span>`;
                }
                
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function quickValidate(id) {
        if (!confirm('Apakah Anda sudah memeriksa dan menyetujui Surat Kesediaan ini?')) return;
        
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('_method', 'PUT');
        formData.append('is_kesediaan_valid', '1');
        
        // We need other required fields to keep them same, but our controller validates 'judul' etc.
        // It might be better to create a specific endpoint for this, or just fetch the data first.
        // For simplicity, let's just trigger the edit modal but maybe with a pre-submit.
        // Actually, let's just use the edit modal fetch to get all data first.
        fetch(`/portal/seminar/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const updateData = new FormData();
                updateData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                updateData.append('_method', 'PUT');
                updateData.append('judul', data.judul);
                updateData.append('pembimbing1_id', data.pembimbing1_id);
                updateData.append('pembimbing2_id', data.pembimbing2_id || '');
                updateData.append('penguji_seminar_id', data.penguji_seminar_id || '');
                updateData.append('acc_seminar', data.acc_seminar);
                updateData.append('is_kesediaan_valid', '1');
                
                fetch(`/portal/seminar/${id}`, {
                    method: 'POST', // POST with _method PUT
                    body: updateData
                }).then(() => {
                    location.reload();
                });
            });
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // WhatsApp Notification Functions
    let currentSeminarIdForWa = null;

    function openWaModal(id, phoneNumber, message) {
        currentSeminarIdForWa = id;
        document.getElementById('wa_display_number').innerText = phoneNumber || 'Nomor tidak tersedia';
        document.getElementById('wa_display_message').innerText = message;
        
        // Setup direct link for manual fallback
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

        fetch(`/portal/seminar/${id}/notify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: document.getElementById('wa_display_message').innerText
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pesan berhasil dikirim via Wablas!');
                closeWaModal();
            } else {
                alert('Gagal: ' + (data.message || 'Terjadi kesalahan sistem.'));
                btn.disabled = false;
                btnText.innerText = 'Kirim Sekarang';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan koneksi.');
            btn.disabled = false;
            btnText.innerText = 'Kirim Sekarang';
        });
    }

    // Upload Kesediaan Functions
    function openUploadModal(id) {
        currentSeminarId = id;
        const form = document.getElementById('uploadKesediaanForm');
        form.action = `/portal/seminar/${id}/kesediaan`;
        document.getElementById('uploadKesediaanModal').style.display = 'flex';
    }

    function closeUploadModal() {
        document.getElementById('uploadKesediaanModal').style.display = 'none';
    }

    function openUploadBuktiBayarModal(id) {
        const form = document.getElementById('uploadBuktiBayarForm');
        form.action = `/portal/seminar/${id}/bukti-bayar`;
        document.getElementById('input_bukti_bayar').value = '';
        document.getElementById('uploadBuktiBayarModal').style.display = 'flex';
    }

    function closeUploadBuktiBayarModal() {
        document.getElementById('uploadBuktiBayarModal').style.display = 'none';
    }
</script>
@endpush
@endsection
