@extends('layouts.app')

@section('title', 'Riwayat Praktek Lapang')

@section('topbar-nav')
    <a href="#">Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatPraktekLapang') }}" class="active">Praktek Lapang</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
        <div>
            <h1 class="page-title" style="margin-bottom: 8px;">Riwayat <span>Praktek Lapang</span></h1>
            <p class="page-desc" style="max-width: 600px;">
                Kelola dan pantau seluruh riwayat pengajuan magang serta praktek kerja lapangan Anda dalam satu dasbor terintegrasi.
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <a href="{{ route('portal.praktekLapang') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px; border-radius: 999px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah praktek lapang baru
            </a>
        </div>
    </div>

    {{-- ── Context Chips ── --}}
    <!-- <div style="display: flex; gap: 16px; margin-bottom: 32px;">
        <div class="card" style="padding: 16px 24px; display: flex; align-items: center; gap: 16px; background: var(--bg-page); border: none;">
            <div style="padding: 10px; background: rgba(2, 195, 154, 0.1); border-radius: 12px; color: var(--brand);">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            </div>
            <div>
                <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">TOTAL SELESAI</div>
                <div style="font-size: 20px; font-weight: 800;">02 Periode</div>
            </div>
        </div>
        <div class="card" style="padding: 16px 24px; display: flex; align-items: center; gap: 16px; background: var(--bg-page); border: none;">
            <div style="padding: 10px; background: rgba(0, 104, 118, 0.1); border-radius: 12px; color: #006876;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
            <div>
                <div style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase;">DALAM PROSES</div>
                <div style="font-size: 20px; font-weight: 800;">01 Pengajuan</div>
            </div>
        </div>
    </div> -->

    {{-- ── Filter Bar ── --}}
    <form action="{{ route('portal.riwayatPraktekLapang') }}" method="GET" class="card" style="padding: 24px; background: var(--bg-page); margin-bottom: 24px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 16px; align-items: flex-end;">
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Cari Nama / NIM</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Contoh: Budi Santoso" style="background: #fff; border: none;">
            </div>
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Program Studi</label>
                <select name="prodi" class="form-control form-select" style="background: #fff; border: none;">
                    <option value="">Semua Program Studi</option>
                    <option value="Informatika" {{ request('prodi') == 'Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi" {{ request('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                </select>
            </div>
            <div>
                <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 8px;">Status</label>
                <select name="status" class="form-control form-select" style="background: #fff; border: none;">
                    <option value="">Semua Status</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 12px 32px; gap: 8px; border-radius: 999px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 3H2l8 9v6l4 2v-8l8-9z"></path></svg>
                Terapkan Filter
            </button>
        </div>
    </form>

    {{-- ── Data Table ── --}}
    <div class="card" style="overflow: hidden; margin-bottom: 0;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page); border-bottom: 1px solid var(--border-light);">
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Identitas Mahasiswa</th>
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Program Studi</th>
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Detail Praktek</th>
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px;">Pembimbing</th>
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; text-align: center;">Status</th>
                        <th style="padding: 16px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($prakteks as $praktek)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 20px 24px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--brand-light); color: var(--brand); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px;">
                                        {{ substr($praktek->mahasiswa->nama ?? 'M', 0, 1) }}{{ substr(explode(' ', $praktek->mahasiswa->nama ?? ' ')[1] ?? '', 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 700;">{{ $praktek->mahasiswa->nama ?? 'N/A' }}</div>
                                        <div style="font-size: 11px; color: var(--text-muted);">{{ $praktek->nim }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <span style="background: rgba(3, 101, 140, 0.1); color: var(--accent); font-size: 9px; font-weight: 800; padding: 4px 8px; border-radius: 4px; text-transform: uppercase;">
                                    {{ $praktek->mahasiswa->prodi->nama ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="padding: 20px 24px;">
                                @if($praktek->laporan)
                                    <a href="{{ asset('storage/' . $praktek->laporan) }}" target="_blank" class="btn btn-ghost btn-sm" style="padding: 4px 10px; font-size: 11px; border-radius: 6px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                        Download Laporan
                                    </a>
                                @else
                                    <div style="font-size: 12px; color: var(--text-muted); font-style: italic;">Belum ada laporan</div>
                                @endif
                                <div style="font-size: 11px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; margin-top: 6px;">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    {{ $praktek->lokasi ?? 'TBA' }}
                                </div>
                            </td>
                            <td style="padding: 20px 24px;">
                                <div style="font-size: 13px;">{{ $praktek->dosenPembimbing->nama ?? '-' }}</div>
                            </td>
                            <td style="padding: 20px 24px; text-align: center;">
                                @php
                                    $praktek_status = !empty($praktek->bukti_bayar) ? 'Disetujui' : 'Menunggu';
                                @endphp
                                @if($praktek_status == 'Disetujui')
                                    <span class="badge badge-green">DISETUJUI</span>
                                @else
                                    <span class="badge" style="background: #FFFBEB; color: #92400E;">MENUNGGU</span>
                                @endif
                            </td>
                            <td style="padding: 20px 24px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('kaprodi'))
                                        <button type="button" class="topbar-icon-btn" onclick="editPraktek({{ $praktek->id }})" title="Edit Data" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        <form action="{{ route('portal.praktekLapang.destroy', $praktek->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display:inline;">
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
                                Tidak ada data praktek lapang ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div style="padding: 16px 24px; background: #fff; border-top: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between;">
            <p style="font-size: 11px; color: var(--text-muted);">
                Menampilkan <strong>{{ $prakteks->firstItem() ?? 0 }}</strong> sampai <strong>{{ $prakteks->lastItem() ?? 0 }}</strong> dari <strong>{{ $prakteks->total() }}</strong> data
            </p>
            <div class="pagination-links">
                {{ $prakteks->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" style="display:none; position:fixed; inset:0; background:rgba(15, 23, 42, 0.7); backdrop-filter: blur(4px); z-index:10000; align-items:center; justify-content:center; padding: 20px;">
        <div class="card" style="width:100%; max-width:500px; padding:0; background:#fff; border-radius: 20px; overflow: hidden;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding: 24px; border-bottom: 1px solid var(--border-light);">
                <h2 style="font-size:18px; font-weight:800; color: var(--text-primary);">Edit Data Praktek Lapang</h2>
                <button onclick="closeModal()" style="border:none; background:none; cursor:pointer; font-size:24px; color: var(--text-muted);">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" style="padding: 24px;">
                @csrf
                @method('PUT')
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Lokasi Penelitian</label>
                    <input type="text" name="lokasi" id="edit_lokasi" class="form-control" required>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Dosen Pembimbing</label>
                    <select name="dosen_pembimbing_id" id="edit_dosen" class="form-control" required>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Laporan Akhir (PDF)</label>
                        <input type="file" name="laporan" class="form-control" accept=".pdf">
                        <p style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">Pilih file untuk ganti laporan.</p>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Bukti Bayar (PDF)</label>
                        <input type="file" name="bukti_bayar" class="form-control" accept=".pdf,image/*">
                        <p style="font-size: 10px; color: var(--text-muted); margin-top: 4px;">Pilih file untuk ganti bukti bayar.</p>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary" style="border-radius: 10px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px; font-weight: 700;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function editPraktek(id) {
        fetch(`/portal/praktek-lapang/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editForm');
                form.action = `/portal/praktek-lapang/${id}`;
                document.getElementById('edit_lokasi').value = data.lokasi;
                document.getElementById('edit_dosen').value = data.dosen_pembimbing_id;
                
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    
    // Close modal on click outside
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endpush
@endsection
