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
        <div>
            <a href="{{ route('portal.seminar') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah seminar baru
            </a>
        </div>
    </div>

    {{-- ── Filter & Search Section ── --}}
    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" placeholder="Cari judul seminar atau nama pembimbing..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
            <button class="btn btn-primary btn-sm" style="padding: 10px 24px;">Cari</button>
        </div>
        <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">STATUS PENGAJUAN</div>
            <select class="form-control form-select" style="padding: 6px 12px; border: none;">
                <option>Semua Status</option>
                <option>Disetujui</option>
                <option>Menunggu</option>
                <option>Ditolak</option>
            </select>
        </div>
        <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">PERIODE SEMESTER</div>
            <select class="form-control form-select" style="padding: 6px 12px; border: none;">
                <option>Ganjil 2023/2024</option>
                <option>Genap 2022/2023</option>
                <option>Ganjil 2022/2023</option>
            </select>
        </div>
    </div>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Identitas & Judul</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Waktu & Tanggal</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Dosen Pembimbing</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tim Penguji</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Status</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    {{-- Row 1: Disetujui --}}
                    <tr style="transition: background 0.2s;">
                        <td style="padding: 16px 24px; max-width: 320px;">
                            <div style="font-weight: 700; color: var(--text-primary);">Budi Darmawan</div>
                            <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 8px;">2010411032 • Teknik Informatika</div>
                            <p style="font-size: 13px; font-weight: 600; color: var(--brand-dark); line-height: 1.4;">Implementasi Algoritma Floyd-Warshall dalam Optimasi Rute Logistik Maritim Indonesia</p>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="font-size: 13px; font-weight: 700; color: var(--text-primary);">15 Nov 2023</div>
                            <div style="font-size: 12px; color: var(--text-secondary);">09:00 - 11:00 WIB</div>
                            <div style="margin-top: 8px; font-size: 10px; font-weight: 700; color: var(--accent); display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Ruang Seminar A
                            </div>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="margin-bottom: 8px;">
                                <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 1</div>
                                <div style="font-size: 12px; font-weight: 600;">Dr. Ir. Heru Sujatmiko</div>
                            </div>
                            <div>
                                <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 2</div>
                                <div style="font-size: 12px; font-weight: 600;">Siti Aminah, M.Kom.</div>
                            </div>
                        </td>
                        <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                            Prof. Dr. Agus Salim
                        </td>
                        <td style="padding: 16px 24px;">
                            <span class="badge badge-green">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                Disetujui
                            </span>
                        </td>
                        <td style="padding: 16px 24px; text-align: right;">
                            <button class="btn btn-secondary btn-sm" style="background: var(--brand-dark); color: #fff; border: none; padding: 8px 16px; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Berita Acara
                            </button>
                        </td>
                    </tr>

                    {{-- Row 2: Menunggu --}}
                    <tr style="transition: background 0.2s; border-top: 1px solid var(--border-light);">
                        <td style="padding: 16px 24px; max-width: 320px;">
                            <div style="font-weight: 700; color: var(--text-primary);">Ani Wijaya</div>
                            <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 8px;">2010411055 • Sistem Informasi</div>
                            <p style="font-size: 13px; font-weight: 600; color: var(--brand-dark); line-height: 1.4;">Analisis User Experience pada Aplikasi Digital Government menggunakan Metrik HEART</p>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="font-size: 13px; font-weight: 700; color: var(--text-primary);">22 Des 2023</div>
                            <div style="font-size: 12px; color: var(--text-secondary);">13:30 - 15:30 WIB</div>
                            <div style="margin-top: 8px; font-size: 10px; color: var(--text-muted); font-style: italic;">
                                Menunggu Konfirmasi
                            </div>
                        </td>
                        <td style="padding: 16px 24px;">
                            <div style="margin-bottom: 8px;">
                                <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 1</div>
                                <div style="font-size: 12px; font-weight: 600;">Dr. Linda Sari</div>
                            </div>
                            <div>
                                <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 2</div>
                                <div style="font-size: 12px; font-weight: 600;">Ahmad Faisal, M.T.</div>
                            </div>
                        </td>
                        <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                            Drs. Bambang Sudarmo
                        </td>
                        <td style="padding: 16px 24px;">
                            <span class="badge" style="background: #CDFAF3; color: #007A6E;">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: pulse 2s infinite;"></span>
                                Menunggu
                            </span>
                        </td>
                        <td style="padding: 16px 24px; text-align: right;">
                            <button class="btn btn-secondary btn-sm" disabled style="opacity: 0.5; cursor: not-allowed; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                Locked
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 16px 24px; background: var(--bg-page); display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 12px; color: var(--text-muted);">Menampilkan 2 dari 12 pengajuan</span>
            <div style="display: flex; gap: 8px;">
                <button class="topbar-icon-btn" style="width: 32px; height: 32px;" disabled>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M10 12l-4-4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="btn btn-primary" style="padding: 0; width: 32px; height: 32px; font-size: 12px;">1</button>
                <button class="btn btn-secondary" style="padding: 0; border: none; width: 32px; height: 32px; font-size: 12px;">2</button>
                <button class="btn btn-secondary" style="padding: 0; border: none; width: 32px; height: 32px; font-size: 12px;">3</button>
                <button class="topbar-icon-btn" style="width: 32px; height: 32px;">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 12l4-4-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- ── Bottom Insight ── --}}
    <div style="margin-top: 32px; display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        <div style="background: linear-gradient(135deg, var(--bg-sidebar) 0%, var(--brand) 100%); border-radius: var(--radius-lg); padding: 32px; color: #fff; position: relative; overflow: hidden;">
            <div style="position: relative; z-index: 1;">
                <h3 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">Persiapan Sidang Akhir?</h3>
                <p style="font-size: 13px; color: rgba(255,255,255,0.7); max-width: 400px; margin-bottom: 24px;">Pastikan seluruh berita acara seminar sudah diunduh dan divalidasi oleh sekretariat akademik sebelum pendaftaran skripsi.</p>
                <button class="btn btn-secondary" style="background: #fff; color: var(--brand-dark); border: none; border-radius: var(--radius-full); padding: 12px 32px;">Hubungi Admin Prodi</button>
            </div>
            <svg style="position: absolute; bottom: -40px; right: -40px; color: rgba(255,255,255,0.1); width: 240px; height: 240px;" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3L1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/>
            </svg>
        </div>

        <div class="card" style="padding: 32px; background: var(--bg-page);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h3 style="font-weight: 700; color: var(--text-primary);">Statistik Seminar</h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--brand);">
                    <path d="M3 3v18h18"></path>
                    <path d="M18.7 8l-5.1 5.2-2.8-2.7L7 14.3"></path>
                </svg>
            </div>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 6px;">
                        <span style="font-size: 11px; color: var(--text-secondary);">Seminar Diselesaikan</span>
                        <span style="font-size: 20px; font-weight: 800;">02</span>
                    </div>
                    <div class="progress-bar" style="height: 4px;">
                        <div class="progress-fill" style="width: 66%;"></div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 6px;">
                        <span style="font-size: 11px; color: var(--text-secondary);">Dalam Antrean</span>
                        <span style="font-size: 20px; font-weight: 800;">01</span>
                    </div>
                    <div class="progress-bar" style="height: 4px;">
                        <div class="progress-fill" style="width: 33%; background: #00A896;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
