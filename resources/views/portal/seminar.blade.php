@extends('layouts.app')

@section('title', 'Pendaftaran Seminar')

@section('topbar-nav')
    <a href="#">Academic Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.seminar') }}" class="active">Seminar Registration</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Page Header ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
        <div>
            <h1 class="page-title">Seminar <span>Registration</span></h1>
            <p class="page-desc">
                Initialize your formal defense by submitting the required documentation and scheduling your session.
            </p>
        </div>
        <div style="text-align: right;">
            <div class="reg-note">
                <div class="reg-note-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    </svg>
                    Registration Note
                </div>
                Ensure all uploaded documents are in PDF format and clearly legible. Processing time is 3-5 working days.
            </div>
        </div>
    </div>

    {{-- ── Form Grid ── --}}
    <form action="{{ route('portal.seminar.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px;">
        @csrf
        {{-- Left Col --}}
        <div class="flex flex-col gap-24">
            {{-- Primary Details --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Primary Details</div>
                </div>
                <div class="form-section-body">
                    @if($isStaff)
                        <div class="form-group">
                            <label class="form-label">Pilih Mahasiswa</label>
                            <select name="nim" class="form-control form-select" required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswas as $m)
                                    <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="form-label">Student Full Name</label>
                            <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Student ID (NIM)</label>
                            <input type="text" class="form-control" name="nim" value="{{ $mahasiswa->nim }}" readonly>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Research Topic (Judul) - Added here for Students to balance the layout --}}
            @if(!$isStaff)
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">Research Topic</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label">Thesis Title</label>
                            <textarea name="judul" class="form-control" rows="4" placeholder="Enter your full research title here..." required></textarea>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Scheduling --}}
            @if($isStaff)
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">Scheduling</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-row form-row-2">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Location / Room</label>
                                <input type="text" name="tempat" class="form-control" placeholder="e.g. Ruang Rapat Lt. 1">
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Advisors --}}
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">Advisors</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label">Pembimbing 1</label>
                            <select name="pembimbing1_id" class="form-control form-select" required>
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pembimbing 2</label>
                            <select name="pembimbing2_id" class="form-control form-select">
                                <option value="">Pilih Dosen (Opsional)</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Right Col --}}
        <div class="flex flex-col gap-24">
            {{-- Research Topic - Visible only for Staff here --}}
            @if($isStaff)
                <div class="form-section">
                    <div class="form-section-header">
                        <div class="section-label">Research Topic</div>
                    </div>
                    <div class="form-section-body">
                        <div class="form-group">
                            <label class="form-label">Thesis Title</label>
                            <textarea name="judul" class="form-control" rows="4" placeholder="Enter your full research title here..." required></textarea>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Required Documents --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Required Documents</div>
                </div>
                <div class="form-section-body">
                    <div class="form-group">
                        <label class="form-label">Bukti Bayar (PDF/JPG)</label>
                        <input type="file" name="bukti_bayar" class="form-control">
                        <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Max size 5MB</p>
                    </div>
                </div>
            </div>

            {{-- Submission Bar --}}
            <div class="submission-bar">
                <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(2, 195, 154, 0.2); display: flex; align-items: center; justify-content: center; color: var(--brand);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <div class="submission-bar-text">
                    <div class="submission-bar-title">Final Submission</div>
                    <div class="submission-bar-desc">Please verify all information before submitting to the department.</div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Complete Registration</button>
            </div>
        </div>
    </form>
</div>
@endsection
