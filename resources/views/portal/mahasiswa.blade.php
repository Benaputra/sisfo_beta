@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('topbar-nav')
    <a href="#">Academic Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#">Students</a>
    <span class="breadcrumb-sep">/</span>
    <a href="#" class="active">Budi Santoso Profile</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Profile Hero ── --}}
    <div class="profile-hero">
        <div class="profile-hero-avatar">
            {{-- Placeholder avatar --}}
            BS
        </div>
        <div class="flex-1">
            <h1 class="profile-hero-name">Budi Santoso</h1>
            <p class="profile-hero-quote">
                "Dedicated to advancing sustainable urban architectures through fluid data analysis."
            </p>
            <div class="profile-hero-meta">
                <div class="profile-hero-meta-item">
                    NIM / STUDENT ID
                    <div class="profile-hero-meta-val">20210084022</div>
                </div>
                <div class="profile-hero-meta-item">
                    CURRENT IPK / GPA
                    <div class="profile-hero-meta-val">3.92 / 4.00</div>
                </div>
            </div>
            <div class="profile-hero-badges">
                <span class="profile-hero-badge">Batch 2021</span>
                <span class="profile-hero-badge">Full Scholarship</span>
                <span class="profile-hero-badge">Honors List</span>
            </div>
        </div>
        <div class="items-start">
            <span class="badge badge-green" style="background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">ACTIVE SCHOLAR</span>
        </div>
    </div>

    {{-- ── Content Grid ── --}}
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; margin-bottom: 24px;">

        {{-- Left Col: Details & Progress --}}
        <div class="flex flex-col gap-20">
            {{-- Personal Details --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Personal Details</div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div style="font-size: 13px; font-weight: 500;">budi.santoso@fluid.edu</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <div style="font-size: 13px; font-weight: 500;">+62 812-3456-7890</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <div style="font-size: 13px; font-weight: 500;">Jl. Merdeka No. 12, Kebayoran Baru, Jakarta Selatan</div>
                    </div>
                </div>
            </div>

            {{-- Academic Progress --}}
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="card-title">Academic Progress</div>
                    <a href="#" style="font-size: 11px; color: var(--brand-dark); font-weight: 600; text-decoration: underline;">VIEW TRANSCRIPT</a>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; text-align: center;">
                        <div>
                            <div style="font-size: 20px; font-weight: 800; color: var(--text-primary);">124</div>
                            <div style="font-size: 9px; font-weight: 700; color: var(--text-muted);">CREDITS EARNED</div>
                            <div style="font-size: 8px; color: var(--text-muted);">Total needed: 144 SKS</div>
                        </div>
                        <div>
                            <div style="font-size: 20px; font-weight: 800; color: var(--text-primary);">6th</div>
                            <div style="font-size: 9px; font-weight: 700; color: var(--text-muted);">SEMESTER</div>
                            <div style="font-size: 8px; color: var(--text-muted);">Normal duration: 8 Semesters</div>
                        </div>
                        <div>
                            <div style="font-size: 20px; font-weight: 800; color: var(--text-primary);">92%</div>
                            <div style="font-size: 9px; font-weight: 700; color: var(--text-muted);">ATTENDANCE</div>
                            <div style="font-size: 8px; color: var(--text-muted);">Minimum required: 80%</div>
                        </div>
                    </div>
                    <div style="margin-top: 16px;">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: 86%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Col: Program & Activity --}}
        <div class="flex flex-col gap-20">
            {{-- Academic Program --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Academic Program</div>
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
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">FACULTY</div>
                            <div style="font-size: 13px; font-weight: 600;">Engineering & Design</div>
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
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">PROGRAM OF STUDY</div>
                            <div style="font-size: 13px; font-weight: 600;">S1 Urban Architecture</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; padding: 12px; border: 1px solid var(--border); border-radius: 12px;">
                        <div class="avatar avatar-sm">AS</div>
                        <div>
                            <div style="font-size: 10px; font-weight: 700; color: var(--text-muted);">SUPERVISOR</div>
                            <div style="font-size: 13px; font-weight: 600;">Prof. Dr. Aris Setiawan</div>
                        </div>
                        <svg style="margin-left: auto; color: var(--text-muted);" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Recent Scholarly Activity --}}
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="card-title">Recent Scholarly Activity</div>
                    <div style="display: flex; gap: 8px;">
                        <button style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M7 9l-3-3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button style="width: 24px; height: 24px; border-radius: 50%; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M5 9l3-3-3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 16px;">
                    <div class="activity-card">
                        <div class="activity-card-tag">RESEARCH PAPER</div>
                        <div class="activity-card-title">Dynamic Flow in Vertical Urban Farming Systems</div>
                        <a href="#" class="activity-card-link">Published in Fluid Journal ↗</a>
                    </div>
                    <div class="activity-card">
                        <div class="activity-card-tag">AWARD</div>
                        <div class="activity-card-title">1st Place: Regional Architecture Design Competition</div>
                        <div class="activity-card-link" style="color: var(--text-muted);">DKI Jakarta Council ↗</div>
                    </div>
                    <div class="activity-card">
                        <div class="activity-card-tag">CERTIFICATION</div>
                        <div class="activity-card-title">Advanced BIM Modeling Specialist Level III</div>
                        <div class="activity-card-link" style="color: var(--text-muted);">Credential ID: #44022-X ↗</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
