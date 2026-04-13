@extends('layouts.app')

@section('title', 'Riwayat Skripsi')

@section('topbar-nav')
    <a href="#">Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatSkripsi') }}" class="active">Riwayat Skripsi</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
        <div>
            <div style="display: flex; gap: 8px; margin-bottom: 12px; font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">
                <span>Portal</span>
                <span>/</span>
                <span style="color: var(--brand);">Riwayat Skripsi</span>
            </div>
            <h1 class="page-title">Riwayat <span>Skripsi</span></h1>
            <p class="page-desc" style="max-width: 600px;">
                Kelola dan pantau seluruh status pengajuan skripsi Anda secara real-time melalui sistem akademik terintegrasi.
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <a href="{{ route('portal.skripsi') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px; border-radius: 999px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah skripsi baru
            </a>
        </div>
    </div>

    {{-- ── Filter Section ── --}}
    <div class="grid-4" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 24px; background: var(--bg-page);">
            <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 12px;">CARI JUDUL ATAU MAHASISWA</label>
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1; border: 1px solid var(--border-light);">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" placeholder="Masukkan kata kunci..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
        </div>
        <div class="card" style="padding: 24px; background: var(--bg-page);">
            <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 12px;">STATUS PENGAJUAN</label>
            <select class="form-control form-select" style="padding: 10px 14px; border: none; background: #fff;">
                <option>Semua Status</option>
                <option>Disetujui</option>
                <option>Dalam Proses</option>
                <option>Ditolak</option>
            </select>
        </div>
        <div class="card" style="padding: 24px; background: var(--bg-page); display: flex; align-items: flex-end;">
            <button class="btn btn-secondary btn-full" style="background: var(--bg-sidebar); color: #fff; border: none; padding: 12px;">
                Terapkan Filter
            </button>
        </div>
    </div>

    {{-- ── Table section ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--brand-light); border-bottom: 1px solid var(--border-light);">
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Mahasiswa</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Judul Skripsi</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Sidang</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Pembimbing</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Status</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    {{-- Row 1 --}}
                    <tr style="transition: background 0.2s;">
                        <td style="padding: 24px;">
                            <div style="font-weight: 700; color: var(--text-primary);">Arya Wiguna</div>
                            <div style="font-size: 11px; color: var(--text-muted);">1902441012</div>
                            <div style="margin-top: 4px; font-size: 10px; font-weight: 700; color: var(--accent); text-transform: uppercase;">TEKNIK INFORMATIKA</div>
                        </td>
                        <td style="padding: 24px; max-width: 300px;">
                            <p style="font-size: 13px; font-weight: 500; color: var(--text-primary); line-height: 1.6; font-style: italic;">
                                "Implementasi Algoritma Random Forest pada Analisis Sentimen Mahasiswa terhadap Portal Akademik Berbasis Web"
                            </p>
                        </td>
                        <td style="padding: 24px;">
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <div style="display: flex; items-center; gap: 6px; font-size: 12px; font-weight: 600;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--brand);">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    24 Okt 2023
                                </div>
                                <div style="display: flex; items-center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                    09:00 WIB
                                </div>
                            </div>
                        </td>
                        <td style="padding: 24px;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-light); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800;">P1</div>
                                    <span style="font-size: 12px; font-weight: 600;">Dr. Indah Purnamasari</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-light); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800;">P2</div>
                                    <span style="font-size: 12px; font-weight: 600;">Budi Santoso, M.Kom</span>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 24px;">
                            <span class="badge badge-green" style="padding: 4px 12px;">DISETUJUI</span>
                        </td>
                        <td style="padding: 24px; text-align: right;">
                            <button class="btn btn-primary btn-sm" style="background: var(--brand); border-radius: 8px; font-size: 11px; padding: 8px 16px; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Undangan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div style="padding: 24px; background: #fff; border-top: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between;">
            <p style="font-size: 12px; color: var(--text-muted);">Menampilkan <strong>3</strong> dari <strong>48</strong> data skripsi</p>
            <div style="display: flex; gap: 8px;">
                <button class="topbar-icon-btn" disabled><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 12l-4-4 4-4" stroke="currentColor" stroke-width="1.5"/></svg></button>
                <button class="btn btn-primary" style="width: 36px; height: 36px; padding: 0;">1</button>
                <button class="btn btn-secondary" style="width: 36px; height: 36px; padding: 0; border: none;">2</button>
                <button class="topbar-icon-btn"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12l4-4-4-4" stroke="currentColor" stroke-width="1.5"/></svg></button>
            </div>
        </div>
    </div>

    {{-- ── Help boxes ── --}}
    <div style="margin-top: 32px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
        <div style="padding: 24px; border-radius: var(--radius-lg); background: rgba(2, 195, 154, 0.05); border-left: 4px solid var(--brand);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--brand);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-primary);">Informasi Penting</h3>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                Undangan skripsi hanya dapat diunduh 3 hari sebelum jadwal sidang berlangsung dan status sudah dinyatakan <strong style="color: var(--brand);">Disetujui</strong>.
            </p>
        </div>
        <div style="padding: 24px; border-radius: var(--radius-lg); background: rgba(3, 101, 140, 0.05); border-left: 4px solid var(--accent);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--accent);">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-primary);">Butuh Bantuan?</h3>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                Jika terdapat ketidaksesuaian data pembimbing atau penguji, silakan hubungi bagian Sekretariat Jurusan melalui portal helpdesk.
            </p>
        </div>
        <div style="padding: 24px; border-radius: var(--radius-lg); background: rgba(0, 104, 118, 0.05); border-left: 4px solid #006876;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: #006876;">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-primary);">Revisi & Final</h3>
            </div>
            <p style="font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                Pastikan judul yang tercetak di undangan adalah judul terbaru yang telah disetujui oleh dosen pembimbing Anda.
            </p>
        </div>
    </div>
</div>
@endsection