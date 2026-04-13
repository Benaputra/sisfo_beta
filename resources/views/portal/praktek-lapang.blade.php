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
    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 24px;">

        {{-- Left Form Column --}}
        <div class="flex flex-col gap-24">

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
                            <input type="text" class="form-control" placeholder="e.g. Marine Research Station, Bali">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Research Report Title</label>
                        <textarea class="form-control" rows="3" placeholder="Enter the preliminary title of your field study report..."></textarea>
                    </div>
                </div>
            </div>

            {{-- Academic Supervision --}}
            <div class="form-section">
                <div class="form-section-header">
                    <div class="section-label">Academic Supervision</div>
                </div>
                <div class="form-section-body">
                    <div class="form-row form-row-2">
                        <div class="form-group">
                            <label class="form-label">Assigned Supervisor</label>
                            <select class="form-control form-select">
                                <option>Select Faculty Member</option>
                                <option>Prof. Dr. Aris Setiawan</option>
                                <option>Dr. Budi Santoso</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Proposed Start Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Map & Upload Column --}}
        <div class="flex flex-col gap-24">

            {{-- Map Area --}}
            <div class="card" style="overflow: hidden;">
                <div class="map-container" style="height: 240px; border-radius: 0;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px; position: relative; z-index: 1;">
                        <div class="map-pin"></div>
                        <span style="background: rgba(255,255,255,1); border-radius: 20px; padding: 4px 16px; font-size: 11px; font-weight: 700; color: var(--bg-sidebar); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            Selected Research Area
                        </span>
                    </div>
                    <div style="position: absolute; bottom: 12px; left: 12px;">
                        <span class="badge badge-green" style="font-size: 9px; padding: 4px 10px;">LIVE COORDINATES</span>
                    </div>
                </div>
            </div>

            {{-- Payment Verification --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Payment Verification</div>
                </div>
                <div class="card-body">
                    <p style="font-size: 11px; color: var(--text-muted); margin-bottom: 16px;">
                        Upload your tuition or practice fee receipt in PDF or JPEG format.
                    </p>
                    <div class="upload-zone">
                        <div class="upload-zone-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <div class="upload-zone-label">Click to upload payment proof</div>
                        <div class="upload-zone-hint">Maximum file size 5MB</div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-full" style="margin-top: 24px; border-radius: 12px; padding: 14px;">
                        Submit Registration
                    </button>
                    <div style="margin-top: 12px; text-align: center; font-size: 10px; color: var(--text-muted);">
                        By submitting, you agree to the academic guidelines and fieldwork safety protocols.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
