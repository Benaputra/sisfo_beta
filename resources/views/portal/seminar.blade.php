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
    <form style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px;">
        {{-- Left Col --}}
        <div class="flex flex-col gap-24">
            {{-- Primary Details --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Primary Details</div>
                </div>
                <div class="form-section-body">
                    <div class="form-group">
                        <label class="form-label">Seminar ID</label>
                        <input type="text" class="form-control" value="SEM-2023-001" readonly style="background: var(--bg-page); color: var(--text-muted);">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Student Full Name</label>
                        <input type="text" class="form-control" value="Budi Santoso" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Student ID (NIM)</label>
                        <input type="text" class="form-control" value="G64180001" readonly>
                    </div>
                </div>
            </div>

            {{-- Scheduling --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Scheduling</div>
                </div>
                <div class="form-section-body">
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Location / Room</label>
                        <select class="form-control form-select">
                            <option>Main Hall A-101</option>
                            <option>Seminar Room B-202</option>
                            <option>Virtual Room (Zoom)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Col --}}
        <div class="flex flex-col gap-24">
            {{-- Research Topic --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Research Topic</div>
                </div>
                <div class="form-section-body">
                    <div class="form-group">
                        <label class="form-label">Thesis Title</label>
                        <textarea class="form-control" rows="4" placeholder="Enter your full research title here..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Required Documents --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Required Documents</div>
                </div>
                <div class="form-section-body">
                    <div class="doc-upload-grid">
                        <div class="doc-card">
                            <div class="doc-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div class="doc-card-label">Proof of Payment</div>
                            <div class="doc-card-hint">PDF, JPG up to 5MB</div>
                        </div>
                        <div class="doc-card" style="border-color: var(--brand); background: var(--brand-light);">
                            <div class="doc-card-icon" style="background: var(--brand); color: #fff;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <div class="doc-card-label">Supervisor ACC Letter</div>
                            <div class="doc-card-hint">Signed PDF document</div>
                        </div>
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
                <button type="button" class="btn btn-secondary btn-sm" style="color: #fff; border-color: rgba(255,255,255,0.2);">Save Draft</button>
                <button type="submit" class="btn btn-primary btn-sm">Complete Registration</button>
            </div>
        </div>
    </form>
</div>
@endsection
