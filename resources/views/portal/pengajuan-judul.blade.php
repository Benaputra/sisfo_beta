@extends('layouts.app')

@section('title', 'Pengajuan Judul Skripsi')

@section('topbar-nav')
    <a href="{{ route('portal.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatPengajuanJudul') }}">Pengajuan Judul</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.pengajuanJudul') }}" class="active">Form Pengajuan</a>
@endsection

@section('content')
<div class="animate-fadein">
    {{-- Header --}}
    <div style="margin-bottom: 32px;">
        <h1 class="page-title">Form <span>Pengajuan Judul</span></h1>
        <p class="page-desc">
            Sampaikan judul skripsi Anda untuk mendapatkan persetujuan dan surat kesediaan bimbingan.
        </p>
    </div>

    @if($isMahasiswa)
        @if($existingSubmission)
            {{-- Status Card --}}
            <div class="card" style="padding: 32px; margin-bottom: 24px;">
                <div class="section-label" style="margin-bottom: 24px;">STATUS PENGAJUAN ANDA</div>
                
                <div style="display: flex; align-items: flex-start; gap: 24px; background: var(--bg-body); padding: 24px; border-radius: 16px;">
                    <div style="flex: 1;">
                        <h3 style="font-size: 18px; margin-bottom: 8px; color: var(--text-primary);">{{ $existingSubmission->judul }}</h3>
                        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">Diajukan pada: {{ $existingSubmission->created_at->format('d M Y, H:i') }}</p>
                        
                        <div style="display: inline-flex; align-items: center; gap: 8px; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; 
                            @if($existingSubmission->status == 'pending') background: #FEF3C7; color: #92400E; 
                            @elseif($existingSubmission->status == 'disetujui') background: #D1FAE5; color: #065F46; 
                            @else background: #FEE2E2; color: #991B1B; @endif">
                            <span style="width: 8px; height: 8px; border-radius: 50%; 
                                @if($existingSubmission->status == 'pending') background: #F59E0B; 
                                @elseif($existingSubmission->status == 'disetujui') background: #10B981; 
                                @else background: #EF4444; @endif"></span>
                            {{ ucfirst($existingSubmission->status) }}
                        </div>

                        @if($existingSubmission->keterangan)
                            <div style="margin-top: 16px; font-size: 13px; color: var(--text-primary); background: #fff; padding: 12px; border-radius: 8px; border-left: 4px solid var(--brand);">
                                <strong>Catatan Staff:</strong> {{ $existingSubmission->keterangan }}
                            </div>
                        @endif

                        <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div style="background: rgba(255,255,255,0.5); padding: 12px; border-radius: 10px;">
                                <div style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Pembimbing Utama</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-primary); margin-top: 4px;">
                                    {{ $existingSubmission->pembimbing1->nama ?? 'menunggu pembimbing' }}
                                </div>
                            </div>
                            <div style="background: rgba(255,255,255,0.5); padding: 12px; border-radius: 10px;">
                                <div style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Pembimbing Pendamping</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-primary); margin-top: 4px;">
                                    {{ $existingSubmission->pembimbing2->nama ?? 'menunggu pembimbing' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($existingSubmission->status == 'disetujui' && $existingSubmission->surat_kesediaan)
                        <div style="text-align: right;">
                            <a href="{{ route('portal.pengajuanJudul.downloadSurat', $existingSubmission->id) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Surat
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('portal.riwayatPengajuanJudul') }}" class="btn btn-secondary">
                    Lihat Riwayat Lengkap
                </a>
            </div>
        @else
            {{-- Form Submission --}}
            <div class="card" style="padding: 32px;">
                <form action="{{ route('portal.pengajuanJudul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="max-width: 800px;">
                        <div class="section-label" style="margin-bottom: 24px;">FORM PENGAJUAN</div>
                        
                        <div class="form-group" style="margin-bottom: 24px;">
                            <label class="form-label">Judul Skripsi yang Diusulkan</label>
                            <textarea name="judul" class="form-control" rows="4" placeholder="Masukkan judul lengkap skripsi Anda..." required></textarea>
                            <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Pastikan judul sudah dikonsultasikan dengan calon pembimbing.</p>
                        </div>

                        <div class="form-group" style="margin-bottom: 32px;">
                            <label class="form-label">Bukti Pembayaran Skripsi (PDF/Gambar)</label>
                            <input type="file" name="bukti_bayar" class="form-control" {{ $mahasiswa->angkatan <= 2020 ? 'required' : '' }}>
                            @if($mahasiswa->angkatan <= 2020)
                                <p style="font-size: 11px; color: #EF4444; margin-top: 4px;">* Wajib untuk Angkatan 2020 ke bawah.</p>
                            @else
                                <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Opsional untuk Angkatan {{ $mahasiswa->angkatan }}.</p>
                            @endif
                        </div>

                        <div style="display: flex; gap: 16px; align-items: center;">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Pengajuan</button>
                            <p style="font-size: 12px; color: var(--text-muted); max-width: 300px;">
                                Anda hanya dapat mengirimkan satu judul. Mohon periksa kembali sebelum mengirim.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    @else
        {{-- For Staff/Kaprodi --}}
        <div class="card" style="padding: 32px;">
            <form action="{{ route('portal.pengajuanJudul.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="max-width: 800px;">
                    <div class="section-label" style="margin-bottom: 24px;">PENDAFTARAN OLEH STAF/KAPRODI</div>
                    
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label" for="mahasiswa_select">Pilih Mahasiswa</label>
                        <select name="nim" id="mahasiswa_select" class="form-control" required placeholder="Cari NIM atau Nama Mahasiswa..."></select>
                        <p style="font-size: 11px; color: var(--text-muted); margin-top: 8px;">Ketik minimal 1 karakter untuk mencari mahasiswa.</p>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label">Judul Skripsi yang Diajukan</label>
                        <textarea name="judul" class="form-control" rows="4" placeholder="Masukkan judul lengkap skripsi..." required></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="form-label">Bukti Pembayaran (Opsional)</label>
                        <input type="file" name="bukti_bayar" class="form-control">
                    </div>

                    <div style="display: flex; gap: 16px; align-items: center;">
                        <button type="submit" class="btn btn-primary btn-lg">Daftarkan Mahasiswa</button>
                        <a href="{{ route('portal.riwayatPengajuanJudul') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>

        @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <style>
            .ts-control { 
                border-radius: 12px !important; 
                padding: 10px 14px !important; 
                border: 1px solid var(--border) !important; 
                background: var(--bg-card) !important; 
                color: var(--text-primary) !important;
                font-family: inherit !important;
                font-size: 14px !important;
                box-shadow: none !important;
                transition: var(--transition) !important;
            }
            .ts-wrapper.focus .ts-control {
                border-color: var(--brand) !important;
                box-shadow: 0 0 0 3px rgba(2, 195, 154, 0.12) !important;
            }
            .ts-dropdown { 
                border-radius: 12px !important; 
                box-shadow: var(--shadow-lg) !important; 
                background: var(--bg-card) !important; 
                color: var(--text-primary) !important;
                border: 1px solid var(--border) !important;
                margin-top: 4px !important;
                overflow: hidden !important;
            }
            .ts-dropdown .active { 
                background: var(--brand) !important; 
                color: white !important; 
            }
            .ts-dropdown .option {
                padding: 10px 14px !important;
            }
            .ts-dropdown .option:hover:not(.active) {
                background: var(--bg-page) !important;
            }
            /* Dark theme specifics if needed, but variables should handle most */
            .dark-theme .ts-dropdown .option:hover:not(.active) {
                background: var(--border-light) !important;
            }
        </style>
        @endpush

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var select = new TomSelect('#mahasiswa_select', {
                    valueField: 'id',
                    labelField: 'text',
                    searchField: 'text',
                    loadThrottle: 300,
                    load: function(query, callback) {
                        if (!query.length) return callback();
                        fetch('{{ route('portal.searchMahasiswa') }}?q=' + encodeURIComponent(query))
                            .then(response => response.json())
                            .then(json => {
                                callback(json);
                            }).catch(() => {
                                callback();
                            });
                    },
                    render: {
                        option: function(item, escape) {
                            return '<div>' + escape(item.text) + '</div>';
                        },
                        item: function(item, escape) {
                            return '<div>' + escape(item.text) + '</div>';
                        }
                    }
                });
            });
        </script>
        @endpush
    @endif
</div>
@endsection
