@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
    body { margin: 0; padding: 0; }
</style>
@endpush

@section('content')
    <div class="login-shell animate-fadein">

        {{-- ── Kiri: Panel Hijau ── --}}
        <div class="login-panel">
            {{-- Logo --}}
            <div class="login-panel-logo">
                <div class="login-panel-logo-icon">FS</div>
                <span class="login-panel-logo-name">The Fluid Scholar</span>
            </div>

            {{-- Konten tengah --}}
            <div class="login-panel-content">
                <div class="login-panel-tagline">
                    Where Knowledge<br>Meets <span>Flow.</span>
                </div>
                <p class="login-panel-desc">
                    Access your academic journey through a seamlessly designed portal, built for scholars like you.
                </p>

                {{-- Avatars kolaborator --}}
                <div class="login-panel-avatars">
                    <div class="av" style="background:#059669; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#fff;">A</div>
                    <div class="av" style="background:#0D9488; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#fff;">B</div>
                    <div class="av" style="background:#0891B2; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; color:#fff;">C</div>
                    <span style="margin-left:14px; font-size:12px; color:rgba(255,255,255,0.6);">
                        500+ Active Scholars
                    </span>
                </div>
            </div>

            {{-- Footer panel --}}
            <div style="font-size:11px; color:rgba(255,255,255,0.4); position:relative; z-index:1;">
                © {{ date('Y') }} Academic Flow. All rights reserved.
            </div>
        </div>

        {{-- ── Kanan: Form Login ── --}}
        <div class="login-form-wrapper">
            <div class="login-form-card animate-fadeinup">

                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Please enter your details to continue.</p>

                {{-- Session Error --}}
                @if (session('error'))
                    <div style="background:#FEE2E2; border:1px solid #FCA5A5; border-radius:8px; padding:10px 14px; font-size:13px; color:#991B1B; margin-bottom:16px;">
                        {{ session('error') }}
                    </div>
                @endif

                 @if ($errors->any())
                    <div style="background:#FEE2E2; border:1px solid #FCA5A5; border-radius:8px; padding:10px 14px; font-size:13px; color:#991B1B; margin-bottom:16px;">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                       {{-- Pilih Identitas --}}
                <div style="font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.7px; color:#6B7280; margin-bottom:8px;">
                    SELECT IDENTITY
                </div>
                <div class="identity-selector" id="identity-selector">
                    <button type="button" class="identity-option selected" id="btn-mahasiswa" onclick="selectIdentity('mahasiswa')">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M7 1L1 4.5v.5h12v-.5L7 1z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                            <rect x="2" y="5" width="2" height="4" stroke="currentColor" stroke-width="1.2"/>
                            <rect x="6" y="5" width="2" height="4" stroke="currentColor" stroke-width="1.2"/>
                            <rect x="10" y="5" width="2" height="4" stroke="currentColor" stroke-width="1.2"/>
                            <path d="M0.5 13h13" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                        Mahasiswa
                    </button>
                    <button type="button" class="identity-option" id="btn-dosen" onclick="selectIdentity('dosen')">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <circle cx="7" cy="5" r="2.5" stroke="currentColor" stroke-width="1.2"/>
                            <path d="M1.5 13c0-3 2.5-5 5.5-5s5.5 2 5.5 5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                        Dosen
                    </button>
                    <button type="button" class="identity-option" id="btn-sivitas" onclick="selectIdentity('sivitas')">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M7 1L3 4v6l4 3 4-3V4l-4-3z" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                            <path d="M7 6v4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                        Sivitas
                    </button>
                </div>
                <input type="hidden" id="identity-value" name="identity" value="mahasiswa">

                {{-- Form --}}
                <form method="POST" action="{{ route('portal.login.post') }}">
                    @csrf
                    <input type="hidden" name="identity" id="identity-input" value="mahasiswa">

                    <div class="form-group">
                        <label for="email" class="form-label">Email Institusi</label>
                        <div class="form-control-icon">
                            <svg class="icon" viewBox="0 0 15 15" fill="none">
                                <path d="M1 3.5h13M1 3.5v9h13v-9M1 3.5l6.5 5 6.5-5" stroke="currentColor" stroke-width="1.2" stroke-linejoin="round"/>
                            </svg>
                            <input id="email" type="email" name="email" class="form-control" 
                                   placeholder="akademik@upb.ac.id"
                                   value="{{ old('email') }}" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="form-control-icon">
                            <svg class="icon" viewBox="0 0 15 15" fill="none">
                                <circle cx="5.5" cy="6.5" r="3" stroke="currentColor" stroke-width="1.2"/>
                                <path d="M8 9l5 5M12 9l1.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                            <input id="password" type="password" name="password" class="form-control" 
                                   placeholder="••••••••••"
                                   autocomplete="current-password" required>
                        </div>
                    </div>

                    <div class="login-options">
                        <label class="login-remember">
                            <input type="checkbox" name="remember" id="remember">
                            <span style="font-size:12.5px; color:#6B7280;">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:12.5px; color:#00A896; font-weight:600;">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-full btn-lg" style="margin-bottom:16px;">
                        Masuk ke Portal
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <div class="login-divider">ATAU HUBUNGKAN DENGAN</div>

                <button type="button" class="login-sso-btn">
                    <svg width="18" height="18" viewBox="0 0 18 18">
                        <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 01-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.615z" fill="#4285F4"/>
                        <path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 009 18z" fill="#34A853"/>
                        <path d="M3.964 10.71A5.41 5.41 0 013.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 000 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
                        <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 00.957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
                    </svg>
                    Academic Single Sign On
                </button>

                <p class="login-footer">
                    Belum punya akun?
                    <a href="#">Ajukan Pendaftaran</a>
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function selectIdentity(role) {
                // update hidden input
                document.getElementById('identity-input').value = role;

                // remove selected class semua tombol
                document.querySelectorAll('.identity-option').forEach(btn => {
                    btn.classList.remove('selected');
                });

                // tambahkan selected ke yang dipilih
                document.getElementById('btn-' + role).classList.add('selected');
            }
        </script>
    @endpush
@endsection

