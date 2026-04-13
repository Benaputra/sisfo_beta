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
<div class="animate-fadein">

    {{-- ── Main Grid ── --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">

        {{-- Left Column: Info & Checklist --}}
        <div>
            <h1 class="page-title">Pendaftaran <span>Skripsi</span></h1>
            <p class="page-desc" style="margin-bottom: 32px;">
                Begin your final academic milestone. Submit your research proposal details and required documentation through our fluid scholarly portal.
            </p>

            <div class="card" style="border: none; box-shadow: none; background: transparent;">
                <div class="section-label">SUBMISSION CHECKLIST</div>
                <ul class="checklist" style="margin-top: 16px;">
                    <li>
                        <div class="check-icon">
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                <path d="M13.5 4.5l-7 7L3 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        Valid Transcript (PDF)
                    </li>
                    <li>
                        <div class="check-icon">
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                <path d="M13.5 4.5l-7 7L3 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        TOEFL Certificate (>450)
                    </li>
                    <li>
                        <div class="check-icon">
                            <svg width="12" height="12" viewBox="0 0 16 16" fill="none">
                                <path d="M13.5 4.5l-7 7L3 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        Proof of Payment
                    </li>
                </ul>
            </div>

            <div style="margin-top: 40px; border-radius: 20px; overflow: hidden; position: relative; height: 180px;">
                <img src="https://images.unsplash.com/photo-1523240715630-991c2f82643e?auto=format&fit=crop&q=80&w=600" alt="Institutional Workspace" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); padding: 20px; display: flex; flex-direction: column; justify-content: flex-end;">
                    <div style="font-size: 10px; font-weight: 700; color: var(--brand); text-transform: uppercase; letter-spacing: 1px;">RESEARCH HUB</div>
                    <div style="font-size: 18px; font-weight: 700; color: #fff;">Academic Excellence</div>
                </div>
            </div>
        </div>

        {{-- Right Column: Form --}}
        <div>
            <div class="card" style="padding: 32px;">
                <form>
                    {{-- Personal Identity --}}
                    <div class="section-label" style="margin-bottom: 24px;">PERSONAL IDENTITY</div>
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Student Full Name</label>
                            <input type="text" class="form-control" placeholder="e.g. Aris Setiawan">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Student Identification (NIM)</label>
                            <input type="text" class="form-control" placeholder="e.g. G24180001">
                        </div>
                    </div>

                    {{-- Thesis Particulars --}}
                    <div class="section-label" style="margin-top: 32px; margin-bottom: 24px;">THESIS PARTICULARS</div>
                    <div class="form-group">
                        <label class="form-label">Thesis Title</label>
                        <textarea class="form-control" rows="4" placeholder="Enter the full working title of your research..."></textarea>
                    </div>

                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Proposed Supervisor I</label>
                            <select class="form-control form-select">
                                <option>Select Academic Supervisor</option>
                                <option>Prof. Dr. Aris Setiawan</option>
                                <option>Dr. Budi Santoso</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Proposed Supervisor II</label>
                            <select class="form-control form-select">
                                <option>Select Academic Supervisor</option>
                                <option>Prof. Dr. Aris Setiawan</option>
                                <option>Dr. Budi Santoso</option>
                            </select>
                        </div>
                    </div>

                    {{-- Digital Archives --}}
                    <div class="section-label" style="margin-top: 32px; margin-bottom: 24px;">DIGITAL ARCHIVES</div>
                    <div style="display: flex; gap: 12px; margin-bottom: 32px;">
                        <div class="doc-card" style="flex: 1; padding: 12px;">
                            <div class="doc-card-icon" style="width: 32px; height: 32px; margin-bottom: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                            <div style="font-size: 11px; font-weight: 700;">Payment Proof</div>
                            <div style="font-size: 9px; color: var(--text-muted);">PDF or JPG (Max 2MB)</div>
                        </div>
                        <div class="doc-card" style="flex: 1; padding: 12px;">
                            <div class="doc-card-icon" style="width: 32px; height: 32px; margin-bottom: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <div style="font-size: 11px; font-weight: 700;">Transcript</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Official Academic Record</div>
                        </div>
                        <div class="doc-card" style="flex: 1; padding: 12px;">
                            <div class="doc-card-icon" style="width: 32px; height: 32px; margin-bottom: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            <div style="font-size: 11px; font-weight: 700;">TOEFL Score</div>
                            <div style="font-size: 9px; color: var(--text-muted);">Minimum 450 required</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full btn-lg">Complete Registration</button>
                    <div style="margin-top: 16px; font-size: 11px; color: var(--text-muted); text-align: center;">
                        By clicking register, you verify that all provided data is accurate and fulfills academic requirements.
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
