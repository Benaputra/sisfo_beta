@extends('layouts.app')

@section('title', 'Dashboard Akademik')

@section('topbar-nav')
    <a href="{{ route('portal.dashboard') }}" class="{{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">Overview</a>
    <a href="#">Analytics</a>
    <a href="#">Reports</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between mb-24" style="margin-bottom:24px;">
        <div>
            <h1 class="text-3xl font-extrabold text-primary" style="font-size:28px; font-weight:800; line-height:1.2;">
                Institutional Pulse
            </h1>
            <p class="text-secondary" style="font-size:13px; margin-top:4px; color:#6B7280;">
                Real-time academic throughput monitoring for the Department of Computational Linguistics.
            </p>
        </div>
        <!-- <button class="btn btn-primary btn-sm" style="gap:6px;">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            New Research
        </button> -->
    </div>

    {{-- ── Row 1: Stats ── --}}
    <div class="grid-2" style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

        {{-- Skripsi Registrants --}}
        <div class="stat-card animate-fadeinup delay-1">
            <div class="flex items-center justify-between mb-8" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
                <div>
                    <div class="stat-label">CURRENT TERM</div>
                    <div style="font-size:14px; font-weight:700; color:var(--text-primary);">Skripsi Registrants</div>
                </div>
            </div>
            <div style="display:flex; align-items:flex-end; gap:12px; margin-bottom:16px;">
                <div class="stat-value">142</div>
                <span class="stat-change">↑12%</span>
            </div>
            {{-- Bar chart --}}
            <div class="bar-chart" style="height:64px;">
                @foreach([40, 55, 45, 70, 60, 80, 75, 90, 100, 110, 130, 142] as $i => $h)
                <div class="bar-chart-bar {{ $i === 11 ? 'active' : '' }}"
                     style="height:{{ round($h/142*100) }}%; min-height:8px;">
                </div>
                @endforeach
            </div>
        </div>

        {{-- Seminar Schedule --}}
        <div class="card animate-fadeinup delay-2">
            <div class="card-header">
                <div>
                    <div class="card-title">Seminar Schedule</div>
                    <div class="card-subtitle">Upcoming research presentations for this week.</div>
                </div>
            </div>
            <div class="card-body" style="padding:14px 16px;">
                <div class="schedule-item">
                    <div class="schedule-day-badge">Mon</div>
                    <div>
                        <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Linguistics Data Mining</div>
                        <div style="font-size:11px; color:var(--text-muted);">8 Students Scheduled</div>
                    </div>
                    <svg style="margin-left:auto; color:var(--text-muted);" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="schedule-item">
                    <div class="schedule-day-badge" style="background:#059669;">Wed</div>
                    <div>
                        <div style="font-size:13px; font-weight:600; color:var(--text-primary);">AI Ethics Seminar</div>
                        <div style="font-size:11px; color:var(--text-muted);">14 Students Scheduled</div>
                    </div>
                    <svg style="margin-left:auto; color:var(--text-muted);" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Row 2: Map + Growth ── --}}
    <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px; margin-bottom:16px;">

        {{-- Field Practice Map --}}
        <div class="card animate-fadeinup delay-2">
            <div class="card-header">
                <div>
                    <div class="card-title">Field Practice Map</div>
                    <div class="card-subtitle">Geographical distribution of internship partners and student placements across the region.</div>
                </div>
                <span class="badge badge-brand" style="font-size:10px;">Live Tracking</span>
            </div>
            <div class="card-body">
                <div style="display:flex; gap:20px; margin-bottom:16px;">
                    <div>
                        <div style="font-size:26px; font-weight:800; color:var(--text-primary);">58</div>
                        <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.7px; color:var(--text-muted);">Active Partners</div>
                    </div>
                    <div>
                        <div style="font-size:26px; font-weight:800; color:var(--text-primary);">112</div>
                        <div style="font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.7px; color:var(--text-muted);">Placed Students</div>
                    </div>
                </div>
                {{-- Map visual --}}
                <div class="map-container" style="height:140px;">
                    <div style="display:flex; flex-direction:column; align-items:center; gap:8px; position:relative; z-index:1;">
                        <div class="map-pin"></div>
                        <span style="background:rgba(255,255,255,0.15); border-radius:20px; padding:4px 12px; font-size:11px; font-weight:600; color:#fff; backdrop-filter:blur(4px);">
                            Selected Research Area
                        </span>
                    </div>
                    {{-- Decorative dots --}}
                    <div style="position:absolute; top:20px; left:30px; width:8px; height:8px; border-radius:50%; background:rgba(255,255,255,0.4);"></div>
                    <div style="position:absolute; top:50px; right:40px; width:6px; height:6px; border-radius:50%; background:rgba(255,255,255,0.3);"></div>
                    <div style="position:absolute; bottom:30px; left:60px; width:5px; height:5px; border-radius:50%; background:rgba(255,255,255,0.25);"></div>
                </div>
            </div>
        </div>

        {{-- Annual Enrollment Growth --}}
        <div style="background:linear-gradient(140deg, #07312E 0%, #02C39A 100%); border-radius:var(--radius-lg); padding:24px; display:flex; flex-direction:column; justify-content:center; box-shadow:var(--shadow-md);" class="animate-fadeinup delay-3">
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:12px;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 12L6 8l3 3 5-7" stroke="#02C39A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div style="font-size:48px; font-weight:800; color:#fff; line-height:1;">24%</div>
            <div style="font-size:13px; color:rgba(255,255,255,0.65); margin-top:6px;">Annual Enrollment Growth</div>
            <div style="height:2px; background:rgba(255,255,255,0.15); margin-top:20px; border-radius:2px;">
                <div style="width:24%; height:100%; background:#fff; border-radius:2px;"></div>
            </div>
        </div>
    </div>

    {{-- ── Row 3: Activity + Critical Windows ── --}}
    <div style="display:grid; grid-template-columns:1.5fr 1fr; gap:16px;">

        {{-- Recent Academic Flow --}}
        <div class="card animate-fadeinup delay-3">
            <div class="card-header">
                <div class="card-title">Recent Academic Flow</div>
                <a href="#" style="font-size:12px; color:var(--brand-dark); font-weight:600;">View All</a>
            </div>
            <div class="card-body" style="padding:0 0;">
                @php
                $activities = [
                    ['name' => 'Riza Mahendra',    'action' => 'submitted',  'item' => 'Skripsi Phase 1',          'dept' => 'Computational Linguistics', 'time' => '2 minutes ago', 'status' => 'reviewing'],
                    ['name' => 'Sinta Dewi',        'action' => 'completed',  'item' => 'Field Practice Report',    'dept' => 'Linguistics Engineering',   'time' => '25 minutes ago','status' => 'approved'],
                    ['name' => 'Ahmad Fauzi',       'action' => 'registered', 'item' => 'Seminar — AI Ethics',      'dept' => 'Data Science',              'time' => '1 hour ago',   'status' => 'on-site'],
                ];
                @endphp
                @foreach($activities as $act)
                <div class="activity-row" style="padding:12px 16px;">
                    <div class="avatar avatar-md" style="flex-shrink:0;">
                        {{ strtoupper(substr($act['name'], 0, 1)) }}
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-size:13px; color:var(--text-primary);">
                            <strong>{{ $act['name'] }}</strong> {{ $act['action'] }}
                            <strong>{{ $act['item'] }}</strong>
                        </div>
                        <div style="font-size:11px; color:var(--text-muted);">
                            {{ $act['time'] }} · {{ $act['dept'] }}
                        </div>
                    </div>
                    <span class="activity-status status-{{ $act['status'] }}">
                        {{ ucfirst($act['status']) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Critical Windows --}}
        <div class="card animate-fadeinup delay-4">
            <div class="card-header">
                <div class="card-title">Critical Windows</div>
            </div>
            <div class="card-body">
                <div class="critical-item">
                    <div class="critical-bar red"></div>
                    <div>
                        <div class="critical-tag red">2 DAYS REMAINING</div>
                        <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Thesis Registration Deadline</div>
                        <div style="font-size:11px; color:var(--text-muted);">Spring Term Batch 2</div>
                    </div>
                </div>
                <div class="critical-item">
                    <div class="critical-bar yellow"></div>
                    <div>
                        <div class="critical-tag yellow">IN PROGRESS</div>
                        <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Field Practice Reports</div>
                        <div style="font-size:11px; color:var(--text-muted);">Mid-term evaluation window</div>
                    </div>
                </div>
                <div class="critical-item">
                    <div class="critical-bar" style="background:#3B82F6;"></div>
                    <div>
                        <div class="critical-tag" style="color:#3B82F6;">STARTS NEXT WEEK</div>
                        <div style="font-size:13px; font-weight:600; color:var(--text-primary);">Proposal Defense Registration</div>
                        <div style="font-size:11px; color:var(--text-muted);">Graduating class of 2024</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
