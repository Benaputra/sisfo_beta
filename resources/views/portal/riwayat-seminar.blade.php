@extends('layouts.app')

@section('title', 'Riwayat Seminar')

@section('topbar-nav')
    <a href="#">Home</a>
    <a href="{{ route('portal.riwayatSeminar') }}" class="active">Riwayat</a>
    <a href="#">Jadwal</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
        <div>
            <div class="section-label" style="display: inline-block; margin-bottom: 12px; padding: 2px 10px;">PORTAL AKADEMIK</div>
            <h1 class="page-title">Riwayat <span>Seminar</span></h1>
            <p class="page-desc">Kelola dan pantau seluruh pengajuan seminar Anda. Di sini Anda dapat melihat status persetujuan, jadwal, dan mengunduh berita acara resmi.</p>
        </div>
        <div>
            <a href="{{ route('portal.seminar') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah seminar baru
            </a>
        </div>
    </div>

    {{-- ── Filter & Search Section ── --}}
    <form action="{{ route('portal.riwayatSeminar') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul seminar atau nama pembimbing..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 10px 24px;">Cari</button>
        </div>
        <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">STATUS PENGAJUAN</div>
            <select name="status" class="form-control form-select" style="padding: 6px 12px; border: none;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="card" style="padding: 16px; background: var(--bg-page);">
            <div class="form-label" style="font-size: 9px; margin-bottom: 4px;">PERIODE SEMESTER</div>
            <select class="form-control form-select" style="padding: 6px 12px; border: none;">
                <option>Ganjil 2023/2024</option>
                <option>Genap 2022/2023</option>
                <option>Ganjil 2022/2023</option>
            </select>
        </div>
    </form>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Identitas & Judul</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Waktu & Tanggal</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Dosen Pembimbing</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tim Penguji</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Status</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($seminars as $seminar)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 16px 24px; max-width: 320px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $seminar->mahasiswa->nama ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 8px;">{{ $seminar->nim }} • {{ $seminar->mahasiswa->prodi->nama ?? 'N/A' }}</div>
                                <p style="font-size: 13px; font-weight: 600; color: var(--brand-dark); line-height: 1.4;">{{ $seminar->judul }}</p>
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($seminar->tanggal)
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text-primary);">{{ $seminar->tanggal->format('d M Y') }}</div>
                                    <div style="font-size: 12px; color: var(--text-secondary);">{{ $seminar->waktu ?? '09:00 - 11:00' }} WIB</div>
                                    <div style="margin-top: 8px; font-size: 10px; font-weight: 700; color: var(--accent); display: flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{ $seminar->tempat ?? 'TBA' }}
                                    </div>
                                @else
                                    <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Menunggu Jadwal</div>
                                @endif
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="margin-bottom: 8px;">
                                    <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 1</div>
                                    <div style="font-size: 12px; font-weight: 600;">{{ $seminar->pembimbing1->nama ?? '-' }}</div>
                                </div>
                                <div>
                                    <div style="font-size: 9px; text-transform: uppercase; opacity: 0.5;">Pembimbing 2</div>
                                    <div style="font-size: 12px; font-weight: 600;">{{ $seminar->pembimbing2->nama ?? '-' }}</div>
                                </div>
                            </td>
                            <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                                {{ $seminar->pengujiSeminar->nama ?? '-' }}
                            </td>
                            <td style="padding: 16px 24px;">
                                @if($seminar->acc_seminar == 'Disetujui')
                                    <span class="badge badge-green">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        Disetujui
                                    </span>
                                @elseif($seminar->acc_seminar == 'Ditolak')
                                    <span class="badge badge-red" style="background: #FEE2E2; color: #991B1B;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="badge" style="background: #CDFAF3; color: #007A6E;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor; animation: pulse 2s infinite;"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px 24px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('kaprodi'))
                                        <button type="button" class="topbar-icon-btn" onclick="editSeminar({{ $seminar->id }})" title="Edit Data" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <form action="{{ route('portal.seminar.destroy', $seminar->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="topbar-icon-btn" title="Hapus Data" style="color: #EF4444; border:none; background:none; cursor:pointer;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    <span>Tidak ada data seminar ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="padding: 16px 24px; background: var(--bg-page); display: flex; align-items: center; justify-content: space-between;">
            <span style="font-size: 12px; color: var(--text-muted);">
                Menampilkan {{ $seminars->firstItem() ?? 0 }} sampai {{ $seminars->lastItem() ?? 0 }} dari {{ $seminars->total() }} pengajuan
            </span>
            <div class="pagination-links">
                {{ $seminars->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div class="card" style="width:100%; max-width:600px; padding:32px; background:var(--bg-card);">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Edit Data Seminar</h2>
                <button onclick="closeModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Judul Seminar</label>
                    <textarea name="judul" id="edit_judul" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Pembimbing 1</label>
                        <select name="pembimbing1_id" id="edit_pembimbing1" class="form-control form-select" required>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pembimbing 2</label>
                        <select name="pembimbing2_id" id="edit_pembimbing2" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="edit_tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tempat</label>
                        <input type="text" name="tempat" id="edit_tempat" class="form-control">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">Penguji Seminar</label>
                    <select name="penguji_seminar_id" id="edit_penguji_seminar" class="form-control form-select">
                            <option value="">N/A</option>
                            @foreach($dosens as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">Status Persetujuan</label>
                    <select name="acc_seminar" id="edit_status" class="form-control form-select">
                        <option value="Menunggu">Menunggu</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editSeminar(id) {
        fetch(`/portal/seminar/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editForm');
                form.action = `/portal/seminar/${id}`;
                document.getElementById('edit_judul').value = data.judul;
                document.getElementById('edit_pembimbing1').value = data.pembimbing1_id;
                document.getElementById('edit_pembimbing2').value = data.pembimbing2_id || '';
                document.getElementById('edit_penguji_seminar').value = data.penguji_seminar_id || '';
                document.getElementById('edit_tanggal').value = data.tanggal ? data.tanggal.split('T')[0] : '';
                document.getElementById('edit_tempat').value = data.tempat || '';
                document.getElementById('edit_status').value = data.acc_seminar;
                
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
@endpush
@endsection
