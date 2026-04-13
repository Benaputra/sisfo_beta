@extends('layouts.app')

@section('title', 'Riwayat Praktek Lapang')

@section('topbar-nav')
    <a href="#">Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatPraktekLapang') }}" class="active">Praktek Lapang</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
        <div>
            <h1 class="page-title" style="margin-bottom: 8px;">Riwayat <span>Praktek Lapang</span></h1>
            <p class="page-desc" style="max-width: 600px;">
                Kelola dan pantau seluruh riwayat pengajuan magang serta praktek kerja lapangan Anda dalam satu dasbor terintegrasi.
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <a href="{{ route('portal.praktekLapang') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px; border-radius: 999px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah praktek lapang baru
            </a>
        </div>
    </div>

    {{-- ── Context Chips ── --}}
    <div style="display: flex; gap: 16px; margin-bottom: 32px;">
        <div class="card" style="padding: 16px 24px; display: flex; align-items: center; gap: 16px; background: var(--bg-page); border: none;">
            <div style="padding: 10px; background: rgba(2, 195, 154, 0.1); border-radius: 12px; color: var(--brand);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
                <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">TOTAL SELESAI</div>
                <div style="font-size: 20px; font-weight: 800;">02 Periode</div>
            </div>
        </div>
        <div class="card" style="padding: 16px 24px; display: flex; align-items: center; gap: 16px; background: var(--bg-page); border: none;">
            <div style="padding: 10px; background: rgba(0, 104, 118, 0.1); border-radius: 12px; color: #006876;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div>
                <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">DALAM PROSES</div>
                <div style="font-size: 20px; font-weight: 800;">01 Pengajuan</div>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="card" style="padding: 24px; background: var(--bg-page); margin-bottom: 24px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: flex-end;">
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Cari Nama / NIM</label>
                <input type="text" class="form-control" placeholder="Contoh: Budi Santoso" style="background: #fff; border: none;">
            </div>
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Program Studi</label>
                <select class="form-control form-select" style="background: #fff; border: none;">
                    <option>Semua Program Studi</option>
                    <option>Teknik Informatika</option>
                    <option>Sistem Informasi</option>
                </select>
            </div>
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Status</label>
                <select class="form-control form-select" style="background: #fff; border: none;">
                    <option>Semua Status</option>
                    <option>Disetujui</option>
                    <option>Menunggu</option>
                </select>
            </div>
            <button class="btn btn-primary" style="padding: 12px 32px; gap: 8px; border-radius: 999px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 3H2l8 9v6l4 2v-8l8-9z"></path></svg>
                Terapkan Filter
            </button>
        </div>
    </div>

    {{-- ── Data Table ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page); border-bottom: 1px solid var(--border-light);">
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Identitas Mahasiswa</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Program Studi</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Detail Praktek</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Pembimbing</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; text-align: center;">Status</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <tr style="transition: background 0.2s;">
                        <td style="padding: 24px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px;">AS</div>
                                <div>
                                    <div style="font-weight: 700;">Adi Saputra</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">1204210045</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 24px;">
                            <span style="background: rgba(3, 101, 140, 0.1); color: var(--accent); font-size: 9px; font-weight: 800; padding: 4px 8px; border-radius: 4px;">S1 TEKNIK INFORMATIKA</span>
                        </td>
                        <td style="padding: 24px;">
                            <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">Optimasi Jaringan SD-WAN</div>
                            <div style="font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                PT. Telekomunikasi Indonesia
                            </div>
                        </td>
                        <td style="padding: 24px;">
                            <div style="font-size: 13px;">Dr. Ir. Heru Susanto</div>
                        </td>
                        <td style="padding: 24px; text-align: center;">
                            <span class="badge badge-green">DISETUJUI</span>
                        </td>
                        <td style="padding: 24px; text-align: right;">
                            <button class="btn btn-secondary btn-sm" style="background: var(--brand-light); color: var(--brand-dark); border: none; padding: 8px 16px; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                Surat Jalan
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection