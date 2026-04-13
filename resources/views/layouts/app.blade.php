<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SISFO FPST UPB') }} — @yield('title', 'Dashboard')</title>
    <meta name="description" content="Portal Akademik SISFO FPST UPB">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">
    @stack('styles')
</head>
<body>
<div class="app-shell">

    {{-- ═══════════════════════════════ SIDEBAR ═══════════════════════════════ --}}
    <aside class="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <!-- <div class="sidebar-logo-icon">FPST</div> -->
            <span>SISFO FPST UPB</span>
        </div>

        {{-- User Info --}}
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                @auth
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @else
                    U
                @endauth
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">
                    @auth {{ auth()->user()->name }} @else Guest @endauth
                </div>
                <div class="sidebar-user-role">
                    @auth {{ auth()->user()->getRoleNames()->first() ?? 'User' }} @else Guest @endauth
                </div>
            </div>
        </div>

        <!-- {{-- New Research Button --}}
        <a href="#" class="sidebar-new-btn">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            New Research
        </a> -->

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <div class="sidebar-nav-label">Portal</div>

            <a href="{{ route('portal.dashboard') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <rect x="1" y="1" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="11" y="1" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="1" y="11" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="11" y="11" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('portal.riwayatSkripsi') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.skripsi') || request()->routeIs('portal.riwayatSkripsi') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <path d="M3 2.5A1.5 1.5 0 014.5 1h9A1.5 1.5 0 0115 2.5v13a.5.5 0 01-.8.4L9 12.5l-5.2 3.4A.5.5 0 013 15.5v-13z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Skripsi
            </a>

            <a href="{{ route('portal.riwayatSeminar') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.riwayatSeminar') || request()->routeIs('portal.seminar') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <path d="M2 5h14M2 9h9M2 13h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Seminar
            </a>

            <a href="{{ route('portal.mahasiswa') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.mahasiswa') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <circle cx="9" cy="6" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 16c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Mahasiswa
            </a>

            <a href="{{ route('portal.riwayatPraktekLapang') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.riwayatPraktekLapang') || request()->routeIs('portal.praktekLapang') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <path d="M9 1.5L1.5 6v.5h15V6L9 1.5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    <rect x="3" y="6.5" width="2.5" height="5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="7.75" y="6.5" width="2.5" height="5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="12.5" y="6.5" width="2.5" height="5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M1 16.5h16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Praktek Lapang
            </a>

            <div class="sidebar-nav-label" style="margin-top:8px;">Bantuan</div>
            <a href="#" class="sidebar-nav-item">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <circle cx="9" cy="9" r="7.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M9 13v-1M9 9.5A2 2 0 109 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Help Center
            </a>

            <div style="margin-top:auto; padding-top:20px;">
                <form method="POST" action="{{ route('portal.logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-nav-item" style="width:100%; border:none; background:none; cursor:pointer; color:#EF4444;">
                        <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                            <path d="M13 9H3m0 0l3-3m-3 3l3 3M11 3h3a2 2 0 012 2v8a2 2 0 01-2 2h-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Logout Session
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- ═══════════════════════════════ MAIN ═══════════════════════════════ --}}
    <div class="main-content">

        {{-- Topbar --}}
        <header class="topbar">
            <span class="topbar-brand">SISFO FPST UPB</span>

            <nav class="topbar-nav">
                @yield('topbar-nav')
            </nav>

            <div class="topbar-spacer"></div>

            <div class="topbar-search">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Search research...
            </div>

            <div class="topbar-actions">
                <div style="position:relative;">
                    <button class="topbar-icon-btn" title="Notifikasi">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5a5 5 0 00-5 5v3l-1.5 2h13L13 9.5v-3a5 5 0 00-5-5z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6.5 13a1.5 1.5 0 003 0" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </button>
                    <span class="notify-badge">3</span>
                </div>

                <button class="topbar-icon-btn" title="Pengaturan">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <circle cx="8" cy="8" r="2.5" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M8 1v1.5M8 13.5V15M15 8h-1.5M2.5 8H1M12.7 3.3l-1.1 1.1M4.4 11.6l-1.1 1.1M12.7 12.7l-1.1-1.1M4.4 4.4L3.3 3.3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="topbar-avatar">
                    @auth {{ strtoupper(substr(auth()->user()->name, 0, 1)) }} @else U @endauth
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content animate-fadein">
            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')
</body>
</html>
