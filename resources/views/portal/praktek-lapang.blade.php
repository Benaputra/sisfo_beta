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
    {{-- ── Hero Section ── --}}
    <div style="margin-bottom: 16px;">
        <div style="font-size: 10px; font-weight: 700; color: var(--brand); text-transform: uppercase; letter-spacing: 1px;">ACADEMIC PORTAL</div>
        <h1 class="page-title" style="font-size: 24px;">Praktek <span>Lapang</span></h1>
        <p class="page-desc" style="max-width: 600px; font-size: 12.5px;">
            Submit your field practice registration details. Ensure all academic requirements and payment proofs are valid before final submission.
        </p>
    </div>

    {{-- ── Main Grid ── --}}
    <form action="{{ route('portal.praktekLapang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">

            {{-- Left Form Column --}}
            <div class="flex flex-col gap-20">

                {{-- Student Information --}}
                @if($isStaff)
                    <div class="form-section">
                        <div class="form-section-header" style="padding: 14px 20px 0;">
                            <div class="section-label" style="margin-bottom: 12px;">Identitas Mahasiswa</div>
                        </div>
                        <div class="form-section-body" style="padding: 0 20px 20px;">
                            <div class="form-group">
                                <label class="form-label" for="mahasiswa_select">Pilih Mahasiswa</label>
                                <select name="nim" id="mahasiswa_select" class="form-control" required placeholder="Cari NIM atau Nama Mahasiswa..."></select>
                                <p style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">Ketik minimal 1 karakter untuk mencari mahasiswa.</p>
                            </div>
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<style>
    .ts-control { border-radius: 12px !important; padding: 10px 14px !important; border: 1px solid var(--border) !important; background: var(--bg-card) !important; color: var(--text-primary) !important; transition: var(--transition) !important; }
    .ts-wrapper.focus .ts-control { border-color: var(--brand) !important; box-shadow: 0 0 0 3px rgba(2, 195, 154, 0.12) !important; }
    .ts-dropdown { border-radius: 12px !important; box-shadow: var(--shadow-lg) !important; background: var(--bg-card) !important; color: var(--text-primary) !important; border: 1px solid var(--border) !important; margin-top: 4px !important; overflow: hidden !important; }
    .ts-dropdown .active { background: var(--brand) !important; color: white !important; }
    .ts-dropdown .option { padding: 10px 14px !important; }
    .ts-dropdown .option:hover:not(.active) { background: var(--bg-page) !important; }
    .dark-theme .ts-dropdown .option:hover:not(.active) { background: var(--border-light) !important; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($isStaff)
    new TomSelect('#mahasiswa_select', {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        loadThrottle: 300,
        load: function(query, callback) {
            if (!query.length) return callback();
            fetch('{{ route('portal.searchMahasiswa') }}?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(json => callback(json))
                .catch(() => callback());
        }
    });

    // Also make Advisors searchable
    document.querySelectorAll('.form-select').forEach(el => {
        new TomSelect(el, { create: false, sortField: { field: "text", direction: "asc" } });
    });
    @endif
});
</script>
@endpush
                        </div>
                    </div>
                @endif

                {{-- General Information --}}
                <div class="form-section">
                    <div class="form-section-header" style="padding: 14px 20px 0;">
                        <div class="section-label" style="margin-bottom: 12px;">General Information</div>
                    </div>
                    <div class="form-section-body" style="padding: 0 20px 20px;">
                        <div class="form-group">
                            <label class="form-label">Research Location</label>
                            <div class="form-control-icon">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <input type="text" name="lokasi" class="form-control" placeholder="e.g. Marine Research Station, Bali" required>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Laporan Akhir (PDF)</label>
                            <div class="form-control-icon">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                                <input type="file" name="laporan" class="form-control" accept=".pdf">
                            </div>
                            <p style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">Opsional: Upload jika sudah tersedia.</p>
                        </div>
                    </div>
                </div>

                {{-- Academic Supervision --}}
                <div class="form-section">
                    <div class="form-section-header" style="padding: 14px 20px 0;">
                        <div class="section-label" style="margin-bottom: 12px;">Academic Supervision</div>
                    </div>
                    <div class="form-section-body" style="padding: 0 20px 20px;">
                        <div class="form-row">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label">Assigned Supervisor</label>
                                <select name="dosen_pembimbing_id" class="form-control form-select" required>
                                    <option value="">Select Faculty Member</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Map & Upload Column --}}
            <div class="flex flex-col gap-20">

                {{-- Payment Verification --}}
                <div class="card">
                    <div class="card-header" style="padding: 14px 20px;">
                        <div class="card-title" style="font-size: 13px;">Payment & Submission</div>
                    </div>
                    <div class="card-body" style="padding: 20px;">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label class="form-label">Proof of Payment (PDF)</label>
                            <input type="file" name="bukti_bayar" class="form-control" required>
                            <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">PDF/JPG max 5MB</p>
                        </div>

                        <button type="submit" class="btn btn-primary btn-full" style="border-radius: 12px; padding: 14px; font-weight: 700;">
                            Submit Registration
                        </button>
                        <div style="margin-top: 12px; text-align: center; font-size: 10px; color: var(--text-muted); line-height: 1.4;">
                            By submitting, you agree to the academic guidelines and fieldwork safety protocols.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
