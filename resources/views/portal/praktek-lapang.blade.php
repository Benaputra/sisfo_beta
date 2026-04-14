@extends('layouts.app')

@section('title', 'Praktek Lapang')

@section('topbar-nav')
    <a href="#">The Fluid Scholar</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#">Research</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.praktekLapang') }}" class="active">Praktek Lapang</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Hero Section ── --}}
    <div style="margin-bottom: 24px;">
        <div style="font-size: 10px; font-weight: 700; color: var(--brand); text-transform: uppercase; letter-spacing: 1px;">ACADEMIC PORTAL</div>
        <h1 class="page-title">Praktek <span>Lapang</span></h1>
        <p class="page-desc" style="max-width: 600px;">
            Submit your field practice registration details. Ensure all academic requirements and payment proofs are valid before final submission.
        </p>
    </div>

    {{-- ── Main Grid ── --}}
    <form action="{{ route('portal.praktekLapang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">

            {{-- Left Form Column --}}
            <div class="flex flex-col gap-24">

                {{-- Student Information --}}
                @if($isStaff)
                    <div class="form-section">
                        <div class="form-section-header">
                            <div class="section-label">Identitas Mahasiswa</div>
                        </div>
                        <div class="form-section-body">
                            <div class="form-group">
                                <label class="form-label">Pilih Mahasiswa</label>
                                <select name="nim" class="form-control form-select" required>
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    @foreach($mahasiswas as $m)
                                        <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- General Information --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">General Information</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label">Research Location</label>
                            <div class="form-control-icon">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <input type="text" name="lokasi" class="form-control" placeholder="e.g. Marine Research Station, Bali" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Academic Supervision --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">Academic Supervision</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Assigned Supervisor</label>
                                <select name="dosen_pembimbing_id" class="form-control form-select" required>
                                    <option value="">Select Faculty Member</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Map & Upload Column --}}
            <div class="flex flex-col gap-24">

                {{-- Payment Verification --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Payment & Submission</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom: 24px;">
                            <label class="form-label">Proof of Payment (PDF)</label>
                            <input type="file" name="bukti_bayar" class="form-control" required>
                            <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">PDF/JPG max 5MB</p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full" style="border-radius: 12px; padding: 14px;">
                            Submit Registration
                        </button>
                        <div style="margin-top: 12px; text-align: center; font-size: 10px; color: var(--text-muted);">
                            By submitting, you agree to the academic guidelines and fieldwork safety protocols.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
