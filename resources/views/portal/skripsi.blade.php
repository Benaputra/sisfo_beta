@extends('layouts.app')

@section('title', 'Pendaftaran Skripsi')

@section('topbar-nav')
    <a href="#">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.skripsi') }}" class="active">Skripsi</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#">Seminar</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#">Mahasiswa</a>
@endsection

@section('content')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 8px !important; padding: 10px 12px !important; }
        .form-grid-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; }
        @media (max-width: 991px) { .form-grid-inner { grid-template-columns: 1fr; } }
    </style>
@endpush

<div class="animate-fadein">
    {{-- Header --}}
    <div style="margin-bottom: 32px;">
        <h1 class="page-title">Pendaftaran <span>Skripsi</span></h1>
        <p class="page-desc">
            Selesaikan tahap akhir akademik Anda dengan mengisi formulir pendaftaran skripsi di bawah ini.
        </p>
    </div>

    <div class="card" style="padding: 32px;">
        <form action="{{ route('portal.skripsi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid-inner">
                {{-- Left Column --}}
                <div>
                    {{-- Personal Identity --}}
                    <div class="section-label" style="margin-bottom: 24px;">PERSONAL IDENTITY</div>
                    <div class="form-group" style="margin-bottom: 24px;">
                        @if($isStaff)
                            <label class="form-label">Pilih Mahasiswa (Lulus Seminar)</label>
                            <select name="nim" id="nim-select" class="form-control" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswas as $m)
                                    <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama }}</option>
                                @endforeach
                            </select>
                        @else
                            <div class="form-row form-row-2">
                                <div class="form-group">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">NIM</label>
                                    <input type="text" class="form-control" name="nim" value="{{ $mahasiswa->nim }}" readonly>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Thesis Particulars --}}
                    <div class="section-label" style="margin-top: 16px; margin-bottom: 24px;">THESIS PARTICULARS</div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="form-label">Thesis Title</label>
                        <textarea name="judul" class="form-control" rows="4" placeholder="Enter the full working title..." required></textarea>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Supervisor I</label>
                            <select name="pembimbing1_id" class="form-control form-select ts-select" required>
                                <option value="">Select Supervisor</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Supervisor II</label>
                            <select name="pembimbing2_id" class="form-control form-select ts-select">
                                <option value="">Select Supervisor</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    {{-- Digital Archives --}}
                    <div class="section-label" style="margin-bottom: 24px;">DIGITAL ARCHIVES</div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="form-label">Bukti Bayar (PDF)</label>
                        <input type="file" name="bukti_bayar" class="form-control">
                    </div>
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="form-label">Transkrip Nilai (PDF)</label>
                        <input type="file" name="transkrip_nilai" class="form-control">
                    </div>
                    <div class="form-group" style="margin-bottom: 32px;">
                        <label class="form-label">Sertifikat TOEFL (PDF)</label>
                        <input type="file" name="toefl" class="form-control">
                    </div>

                    <div style="background: var(--bg-body); padding: 24px; border-radius: 16px; margin-bottom: 24px;">
                        <button type="submit" class="btn btn-primary btn-full btn-lg">Complete Registration</button>
                        <p style="margin-top: 16px; font-size: 11px; color: var(--text-muted); text-align: center; line-height: 1.5;">
                            Pastikan semua data yang diunggah sudah benar dan sesuai dengan persyaratan akademik.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Searchable Student Select
            if (document.getElementById('nim-select')) {
                new TomSelect('#nim-select', {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });
            }
            
            // Searchable Dosen Selects
            document.querySelectorAll('.ts-select').forEach(el => {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });
            });
        });
    </script>
@endpush
@endsection
