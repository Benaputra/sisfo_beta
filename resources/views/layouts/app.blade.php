<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->check() ? auth()->user()->theme . '-theme' : 'light-theme' }}">
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

            @if(auth()->user()->hasRole('mahasiswa'))
            <a href="{{ route('portal.mahasiswa') }}"
               class="sidebar-nav-item {{ request()->routeIs('portal.mahasiswa') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <circle cx="9" cy="6" r="3.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M2 16c0-3.3 3.1-6 7-6s7 2.7 7 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                {{ explode(' ', auth()->user()->name)[0] }} (Profile)
            </a>
            @endif

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

            <!-- <div class="sidebar-nav-label" style="margin-top:8px;">Bantuan</div>
            <a href="#" class="sidebar-nav-item">
                <svg class="nav-icon" viewBox="0 0 18 18" fill="none">
                    <circle cx="9" cy="9" r="7.5" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M9 13v-1M9 9.5A2 2 0 109 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Help Center
            </a> -->

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
            {{-- Mobile Toggle --}}
            <button class="topbar-toggle" id="sidebarToggle">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <span class="topbar-brand">SISFO FPST UPB</span>

            <nav class="topbar-nav">
                @yield('topbar-nav')
            </nav>

            <div class="topbar-spacer"></div>
<!-- 
            <div class="topbar-search">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Search research...
            </div> -->

            <div class="topbar-actions">
                <div style="position:relative;" class="notification-dropdown">
                    <button class="topbar-icon-btn" title="Notifikasi" id="notificationBtn">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5a5 5 0 00-5 5v3l-1.5 2h13L13 9.5v-3a5 5 0 00-5-5z" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M6.5 13a1.5 1.5 0 003 0" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                    </button>
                    @if(isset($notifications) && count($notifications) > 0)
                        <span class="notify-badge">{{ count($notifications) }}</span>
                        <div class="dropdown-menu" id="notificationMenu" style="display:none; position:absolute; right:0; top:40px; background:#fff; border:1px solid var(--border); border-radius:var(--radius-md); width:300px; box-shadow:var(--shadow-lg); z-index:1000;">
                            <div style="padding:12px; font-weight:700; border-bottom:1px solid var(--border); font-size:12px;">Notifikasi</div>
                            <div style="max-height:300px; overflow-y:auto;">
                                @foreach($notifications as $notif)
                                    <div style="padding:12px; font-size:12px; border-bottom:1px solid var(--border-variant); color:var(--text-primary);">
                                        {{ $notif }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <button class="topbar-icon-btn theme-toggle" id="themeToggle" title="Ganti Tema">
                    <svg class="sun-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" style="display: {{ (auth()->check() && auth()->user()->theme === 'dark') ? 'none' : 'block' }};">
                        <circle cx="8" cy="8" r="2.5" stroke="currentColor" stroke-width="1.5"/>
                        <path d="M8 1v1.5M8 13.5V15M15 8h-1.5M2.5 8H1M12.7 3.3l-1.1 1.1M4.4 11.6l-1.1 1.1M12.7 12.7l-1.1-1.1M4.4 4.4L3.3 3.3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <svg class="moon-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" style="display: {{ (auth()->check() && auth()->user()->theme === 'dark') ? 'block' : 'none' }};">
                        <path d="M14.5 9.5a6 6 0 11-8-8 4.5 4.5 0 008 8z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
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

<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.body.classList.toggle('sidebar-open');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            if (sidebar && toggle && document.body.classList.contains('sidebar-open') && 
                !sidebar.contains(e.target) && 
                !toggle.contains(e.target)) {
                document.body.classList.remove('sidebar-open');
            }
        }
    });

    // Toggle notifications
    document.getElementById('notificationBtn')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('notificationMenu');
        if (menu) {
            menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
        }
    });

    document.addEventListener('click', function() {
        const menu = document.getElementById('notificationMenu');
        if (menu) menu.style.display = 'none';
    });

    // Theme Toggle Logic
    const themeToggle = document.getElementById('themeToggle');
    const sunIcon = themeToggle?.querySelector('.sun-icon');
    const moonIcon = themeToggle?.querySelector('.moon-icon');
    const htmlTag = document.documentElement;

    themeToggle?.addEventListener('click', function() {
        const isDark = htmlTag.classList.contains('dark-theme');
        const newTheme = isDark ? 'light' : 'dark';

        // Update UI immediately for better UX
        if (isDark) {
            htmlTag.classList.remove('dark-theme');
            htmlTag.classList.add('light-theme');
            if (sunIcon) sunIcon.style.display = 'block';
            if (moonIcon) moonIcon.style.display = 'none';
        } else {
            htmlTag.classList.remove('light-theme');
            htmlTag.classList.add('dark-theme');
            if (sunIcon) sunIcon.style.display = 'none';
            if (moonIcon) moonIcon.style.display = 'block';
        }

        // Save to Database
        fetch("{{ route('portal.updateTheme') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ theme: newTheme })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Failed to save theme preference');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

@if(session('success'))
    <div id="alert-success" style="position: fixed; top: 20px; right: 20px; background: #10B981; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 9999; animation: slideIn 0.3s ease-out;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    <script>setTimeout(() => document.getElementById('alert-success').style.display='none', 5000);</script>
@endif

@if(session('error'))
    <div id="alert-error" style="position: fixed; top: 20px; right: 20px; background: #EF4444; color: white; padding: 16px 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); z-index: 9999; animation: slideIn 0.3s ease-out;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    <script>setTimeout(() => document.getElementById('alert-error').style.display='none', 5000);</script>
@endif

<style>
@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>

@stack('scripts')
</body>
</html>
