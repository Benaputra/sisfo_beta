@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('topbar-nav')
    <a href="#" class="active">{{ auth()->user()->mahasiswa->nama ?? auth()->user()->name }} Profile</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Profile Hero ── --}}
    <div class="profile-hero">
        <div class="profile-hero-avatar">
            {{ strtoupper(substr(auth()->user()->mahasiswa->nama ?? auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->mahasiswa->nama ?? auth()->user()->name)[1] ?? '', 0, 1)) }}
        </div>
        <div class="flex-1">
            <h1 class="profile-hero-name">{{ auth()->user()->mahasiswa->nama ?? auth()->user()->name }}</h1>
            <p class="profile-hero-quote">
                "Dedicated to advancing academic excellence through integrity and hard work."
            </p>
            <div class="profile-hero-meta">
                <div class="profile-hero-meta-item">
                    NIM / STUDENT ID
                    <div class="profile-hero-meta-val">{{ auth()->user()->nim }}</div>
                </div>
            </div>
        </div>
        <!-- <div class="items-start">
            <span class="badge badge-green" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">ACTIVE STUDENT</span>
        </div> -->
    </div>

    {{-- ── Content Grid ── --}}
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; margin-bottom: 24px;">

        {{-- Left Col: Details & Progress --}}
        <div class="flex flex-col gap-20">
            {{-- Personal Details --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Pribadi</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <div style="font-size: 13px; font-weight: 500;">{{ auth()->user()->email }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Handphone</label>
                        <div style="font-size: 13px; font-weight: 500;">{{ auth()->user()->mahasiswa->no_hp ?? '-' }}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ALAMAT</label>
                        <div style="font-size: 13px; font-weight: 500;">{{ auth()->user()->mahasiswa->alamat ?? 'Kalimantan Barat, Indonesia' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Col: Program & Activity --}}
        <div class="flex flex-col gap-20">
            {{-- Academic Program --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">AKADEMIK</div>
                </div>
                <div class="card-body" style="display: flex; flex-direction: column; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--bg-page); border-radius: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--brand);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">FAKULTAS</div>
                            <div style="font-size: 13px; font-weight: 600;">Pertanian, Sains dan Teknologi</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: var(--bg-page); border-radius: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--brand);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 19l7-7 3 3-7 7-3-3z"></path>
                                <path d="M18 13l-1.5-7.5L2 2l4.5 14.5L14 15l4-2z"></path>
                                <path d="M2 2l5 5"></path>
                                <path d="M9.5 15.5L16 22"></path>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">PROGRAM STUDI</div>
                            <div style="font-size: 13px; font-weight: 600;">{{ auth()->user()->mahasiswa->programStudi->nama ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid var(--border); border-radius: 12px;">
                        <div class="avatar avatar-sm">
                            {{ strtoupper(substr(auth()->user()->mahasiswa->pembimbingAkademik->nama ?? 'PA', 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->mahasiswa->pembimbingAkademik->nama ?? '')[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">PEMBIMBING AKADEMIK</div>
                            <div style="font-size: 13px; font-weight: 600;">{{ auth()->user()->mahasiswa->pembimbingAkademik->nama ?? '-' }}</div>
                        </div>
                        <svg style="margin-left: auto; color: var(--text-muted);" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
