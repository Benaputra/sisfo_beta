@extends('layouts.app')

@section('title', 'Riwayat Skripsi')

@section('topbar-nav')
    <a href="#">Portal</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatSkripsi') }}" class="active">Riwayat Skripsi</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; gap: 24px;">
        <div>
            <div style="display: flex; gap: 8px; margin-bottom: 12px; font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">
                <span>Portal</span>
                <span>/</span>
                <span style="color: var(--brand);">Riwayat Skripsi</span>
            </div>
            <h1 class="page-title">Riwayat <span>Skripsi</span></h1>
            <p class="page-desc" style="max-width: 600px;">
                Kelola dan pantau seluruh status pengajuan skripsi Anda secara real-time melalui sistem akademik terintegrasi.
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <a href="{{ route('portal.skripsi') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px; border-radius: 999px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Tambah skripsi baru
            </a>
        </div>
    </div>

    {{-- ── Filter Section ── --}}
    <form action="{{ route('portal.riwayatSkripsi') }}" method="GET" class="grid-4" style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 24px; background: var(--bg-page);">
            <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 12px;">CARI JUDUL ATAU MAHASISWA</label>
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1; border: 1px solid var(--border-light);">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
        </div>
        <div class="card" style="padding: 24px; background: var(--bg-page);">
            <label style="font-size: 10px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 12px;">STATUS PENGAJUAN</label>
            <select name="status" class="form-control form-select" style="padding: 10px 14px; border: none; background: #fff;">
                <option value="">Semua Status</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Dalam Proses</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div class="card" style="padding: 24px; background: var(--bg-page); display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-secondary btn-full" style="background: var(--bg-sidebar); color: #fff; border: none; padding: 12px;">
                Terapkan Filter
            </button>
        </div>
    </form>

    {{-- ── Table section ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--brand-light); border-bottom: 1px solid var(--border-light);">
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Mahasiswa</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Judul Skripsi</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Sidang</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Pembimbing</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px;">Status</th>
                        <th style="padding: 20px 24px; font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brand-dark); letter-spacing: 1px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($skripsis as $skripsi)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 24px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $skripsi->mahasiswa->nama ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-muted);">{{ $skripsi->nim }}</div>
                                <div style="margin-top: 4px; font-size: 10px; font-weight: 700; color: var(--accent); text-transform: uppercase;">{{ $skripsi->mahasiswa->prodi->nama ?? 'N/A' }}</div>
                            </td>
                            <td style="padding: 24px; max-width: 300px;">
                                <p style="font-size: 13px; font-weight: 500; color: var(--text-primary); line-height: 1.6; font-style: italic;">
                                    "{{ $skripsi->judul }}"
                                </p>
                            </td>
                            <td style="padding: 24px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    @if($skripsi->tanggal)
                                        <div style="display: flex; items-center; gap: 6px; font-size: 12px; font-weight: 600;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--brand);">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            {{ $skripsi->tanggal->format('d M Y') }}
                                        </div>
                                        <div style="display: flex; items-center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <polyline points="12 6 12 12 16 14"></polyline>
                                            </svg>
                                            {{ $skripsi->waktu ?? '09:00' }} WIB
                                        </div>
                                    @else
                                        <div style="font-size: 11px; color: var(--text-muted); font-style: italic;">Belum Dijadwalkan</div>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 24px;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-light); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800;">P1</div>
                                        <span style="font-size: 12px; font-weight: 600;">{{ $skripsi->pembimbing1->nama ?? '-' }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--brand-light); color: var(--brand-dark); display: flex; align-items: center; justify-content: center; font-size: 9px; font-weight: 800;">P2</div>
                                        <span style="font-size: 12px; font-weight: 600;">{{ $skripsi->pembimbing2->nama ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 24px;">
                                @php
                                    $status = strtolower($skripsi->status ?? 'menunggu');
                                    $badgeClass = match($status) {
                                        'disetujui' => 'badge-green',
                                        'proses' => 'badge-blue',
                                        'ditolak' => 'badge-red',
                                        default => 'badge-yellow',
                                    };
                                    $statusLabel = match($status) {
                                        'disetujui' => 'DISETUJUI',
                                        'proses' => 'PROSES',
                                        'ditolak' => 'DITOLAK',
                                        default => 'MENUNGGU',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}" style="padding: 4px 12px;">{{ $statusLabel }}</span>
                                @if($skripsi->is_kesediaan_valid)
                                    <div style="margin-top: 4px; font-size: 9px; color: var(--success); font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        KESEDIAAN VALID
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 24px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px; flex-wrap: wrap;">
                                    {{-- Student Actions --}}
                                    @if(auth()->user()->hasRole('mahasiswa'))
                                        @if($skripsi->canDownloadKesediaan())
                                            <a href="{{ route('portal.skripsi.kesediaan', $skripsi->id) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; gap: 6px;" title="Download Surat Kesediaan">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                Kesediaan
                                            </a>
                                            
                                            @if(!$skripsi->is_kesediaan_valid)
                                                <button type="button" class="btn btn-primary" onclick="openUploadModal({{ $skripsi->id }})" style="padding: 6px 12px; font-size: 11px; gap: 6px;">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                                    Unggah
                                                </button>
                                            @endif
                                        @endif

                                        @if($skripsi->canDownloadUndangan())
                                            <a href="{{ route('portal.skripsi.undangan', $skripsi->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px; gap: 6px;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                                Undangan
                                            </a>
                                        @endif
                                    @endif

                                    {{-- Staff Actions --}}
                                    @if(auth()->user()->hasRole('staff') || auth()->user()->hasRole('kaprodi'))
                                        @if($skripsi->file_kesediaan && !$skripsi->is_kesediaan_valid)
                                            <form action="{{ route('portal.skripsi.validate', $skripsi->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; color: var(--success); border-color: var(--success);" title="Validasi Kesediaan">
                                                    Validasi
                                                </button>
                                            </form>
                                        @endif

                                        <button type="button" class="topbar-icon-btn" onclick="openNotifyModal({{ $skripsi->id }}, '{{ $skripsi->mahasiswa->nama }}')" title="Kirim WA" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11 8.38 8.38 0 0 1 3.8.9L21 3z"></path></svg>
                                        </button>

                                        <button type="button" class="topbar-icon-btn" onclick="editSkripsi({{ $skripsi->id }})" title="Edit Data" style="color: var(--brand); border:none; background:none; cursor:pointer;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>
                                        
                                        <form action="{{ route('portal.skripsi.destroy', $skripsi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display:inline;">
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
                                Tidak ada data skripsi ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div style="padding: 24px; background: #fff; border-top: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between;">
            <p style="font-size: 12px; color: var(--text-muted);">
                Menampilkan <strong>{{ $skripsis->firstItem() ?? 0 }}</strong> sampai <strong>{{ $skripsis->lastItem() ?? 0 }}</strong> dari <strong>{{ $skripsis->total() }}</strong> data skripsi
            </p>
            <div class="pagination-links">
                {{ $skripsis->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
        </div>
    </div>

    {{-- Upload Modal --}}
    <div id="uploadModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div class="card" style="width:100%; max-width:500px; padding:32px; background:#fff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Unggah Surat Kesediaan</h2>
                <button onclick="closeUploadModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                Pastikan surat sudah ditandatangani oleh Pembimbing & Penguji sebelum diunggah.
            </p>
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">File Surat Kesediaan (PDF/JPG/PNG)</label>
                    <input type="file" name="file_kesediaan" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeUploadModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah Berkas</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Notify Modal --}}
    <div id="notifyModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div class="card" style="width:100%; max-width:500px; padding:32px; background:#fff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Kirim Notifikasi WA</h2>
                <button onclick="closeNotifyModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <form id="notifyForm" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom:24px;">
                    <label class="form-label">Pesan untuk <span id="notify_name" style="color: var(--brand);"></span></label>
                    <textarea name="message" id="notify_message" class="form-control" rows="5" required></textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeNotifyModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function filterSkripsiEditOptions() {
        const p1 = document.getElementById('edit_pembimbing1');
        const p2 = document.getElementById('edit_pembimbing2');
        const penguji1 = document.getElementById('edit_penguji1');
        const penguji2 = document.getElementById('edit_penguji2');

        const selectors = [p1, p2, penguji1, penguji2];
        const values = selectors.map(s => s.value);

        // Reset
        selectors.forEach(select => {
            Array.from(select.options).forEach(opt => {
                opt.disabled = false;
                opt.style.display = 'block';
            });
        });

        // Disable
        selectors.forEach((select, index) => {
            const currentVal = values[index];
            if (currentVal && currentVal !== "") {
                selectors.forEach((otherSelect, otherIndex) => {
                    if (index !== otherIndex) {
                        const opt = Array.from(otherSelect.options).find(o => o.value === currentVal);
                        if (opt) { opt.disabled = true; opt.style.display = 'none'; }
                    }
                });
            }
        });
    }

    ['edit_pembimbing1', 'edit_pembimbing2', 'edit_penguji1', 'edit_penguji2'].forEach(id => {
        document.getElementById(id).addEventListener('change', filterSkripsiEditOptions);
    });

    function editSkripsi(id) {
        fetch(`/portal/skripsi/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                const form = document.getElementById('editForm');
                form.action = `/portal/skripsi/${id}`;
                document.getElementById('edit_judul').value = data.judul;
                document.getElementById('edit_pembimbing1').value = data.pembimbing1_id;
                document.getElementById('edit_pembimbing2').value = data.pembimbing2_id || '';
                document.getElementById('edit_penguji1').value = data.penguji1_id || '';
                document.getElementById('edit_penguji2').value = data.penguji2_id || '';
                
                filterSkripsiEditOptions();

                document.getElementById('edit_tanggal').value = data.tanggal ? data.tanggal.split('T')[0] : '';
                document.getElementById('edit_tempat').value = data.tempat || '';
                
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openUploadModal(id) {
        const modal = document.getElementById('uploadModal');
        const form = document.getElementById('uploadForm');
        form.action = `/portal/skripsi/${id}/kesediaan`;
        modal.style.display = 'flex';
    }

    function closeUploadModal() {
        document.getElementById('uploadModal').style.display = 'none';
    }

    function openNotifyModal(id, name) {
        const modal = document.getElementById('notifyModal');
        const form = document.getElementById('notifyForm');
        const nameSpan = document.getElementById('notify_name');
        const messageArea = document.getElementById('notify_message');
        
        form.action = `/portal/skripsi/${id}/notify`;
        nameSpan.innerText = name;
        
        const hour = new Date().getHours();
        const greeting = (hour < 12) ? 'pagi' : ((hour < 15) ? 'siang' : ((hour < 18) ? 'sore' : 'malam'));
        const brandText = "kami dari Fakultas Pertanian, Sains dan Teknologi Universitas Panca Bhakti Pontianak.";
        
        messageArea.value = `Selamat ${greeting} ${name}. ${brandText} Pendaftaran skripsi Anda sedang diproses. Mohon lengkapi berkas atau cek berkala portal Anda. Terima Kasih.`;
        
        modal.style.display = 'flex';
    }

    function closeNotifyModal() {
        document.getElementById('notifyModal').style.display = 'none';
    }
</script>
@endpush
@endsection
