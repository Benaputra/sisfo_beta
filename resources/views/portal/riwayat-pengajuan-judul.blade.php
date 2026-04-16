@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Judul')

@section('topbar-nav')
    <a href="{{ route('portal.dashboard') }}">Home</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('portal.riwayatPengajuanJudul') }}" class="active">Pengajuan Judul</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
        <div>
            <div class="section-label" style="display: inline-block; margin-bottom: 12px; padding: 2px 10px;">PROSES AKADEMIK</div>
            <h1 class="page-title">Riwayat <span>Pengajuan Judul</span></h1>
            <p class="page-desc">
                @if($isStaff)
                    Kelola dan verifikasi seluruh pengajuan judul skripsi mahasiswa. Terbitkan Surat Kesediaan Bimbingan bagi judul yang disetujui.
                @else
                    Pantau status pengajuan judul skripsi Anda. Setelah disetujui, Anda dapat mengunduh Surat Kesediaan Bimbingan untuk melangkah ke tahap Skripsi.
                @endif
            </p>
        </div>
        <div>
            <a href="{{ route('portal.pengajuanJudul') }}" class="btn btn-primary" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Ajukan Judul Baru
            </a>
        </div>
    </div>

    {{-- ── Filter & Search Section ── --}}
    <form action="{{ route('portal.riwayatPengajuanJudul') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, NIM, atau nama mahasiswa..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 10px 24px;">Cari Data</button>
        </div>
    </form>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">No</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Mahasiswa</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Judul Skripsi</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Dosen Pembimbing</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Status</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuans as $p)
                        <tr style="transition: background 0.2s; border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $loop->iteration }}</div>
                            </td>   
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ $p->mahasiswa->nama }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $p->nim }} • Angkatan {{ $p->mahasiswa->angkatan }}</div>
                            </td>
                            <td style="padding: 16px 24px; max-width: 280px;">
                                <div style="font-size: 13px; font-weight: 500; color: var(--text-primary); line-height: 1.4;">{{ $p->judul }}</div>
                                <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">Diajukan: {{ $p->created_at->format('d M Y') }}</div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="display: flex; flex-direction: column; gap: 6px;">
                                    <div>
                                        <div style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 2px;">Pembimbing 1</div>
                                        @if($p->pembimbing1)
                                            <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">{{ $p->pembimbing1->nama }}</div>
                                        @else
                                            <div style="font-size: 11px; color: var(--text-muted); font-style: italic;">menunggu pembimbing</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 2px;">Pembimbing 2</div>
                                        @if($p->pembimbing2)
                                            <div style="font-size: 12px; font-weight: 600; color: var(--text-primary);">{{ $p->pembimbing2->nama }}</div>
                                        @else
                                            <div style="font-size: 11px; color: var(--text-muted); font-style: italic;">menunggu pembimbing</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <span class="badge" style="
                                    @if($p->status == 'pending') background: #FEF3C7; color: #92400E; 
                                    @elseif($p->status == 'disetujui') background: #D1FAE5; color: #065F46; 
                                    @else background: #FEE2E2; color: #991B1B; @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px 24px; text-align: right;">
                                <div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
                                    @if($isStaff)
                                        @php
                                            $hour = now()->format('H');
                                            $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));
                                            $waMessage = "Selamat {$greeting} " . ($p->mahasiswa->nama ?? '') . ". Pengajuan judul skripsi Anda telah DISETUJUI. Surat Kesediaan Bimbingan sudah dapat diunduh di sistem. Terima Kasih.";
                                        @endphp
                                        <button type="button" class="topbar-icon-btn" onclick="openWaModal({{ $p->id }}, '{{ $p->mahasiswa->no_hp ?? '' }}', '{{ addslashes($waMessage) }}')" title="Kirim Notifikasi WA" style="color: #25D366; width: 32px; height: 32px; border: none; background: #E8F9EE;">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 1 1-7.6-11.7 8.38 8.38 0 0 1 3.8.9L21 3.5l-1.5 5.5Z"></path></svg>
                                        </button>

                                        <form action="{{ route('portal.pengajuanJudul.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="topbar-icon-btn" title="Hapus Pengajuan" style="color: #EF4444; width: 32px; height: 32px; border: none; background: #FEF2F2;">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if($isStaff && $p->status == 'pending')
                                        <button class="btn btn-primary btn-sm btn-generate" data-id="{{ $p->id }}" data-nim="{{ $p->nim }}" data-nama="{{ $p->mahasiswa->nama }}" data-judul="{{ $p->judul }}" style="font-size: 11px; padding: 6px 14px;">
                                            Setujui & Generate
                                        </button>
                                    @endif

                                    @if($p->status == 'disetujui')
                                        <div style="display: flex; flex-direction: column; gap: 8px; width: 100%;">
                                            {{-- Tahap 1: Surat Kesediaan --}}
                                            @if(!$p->file_kesediaan)
                                                <div style="background: var(--brand-light); padding: 8px 12px; border-radius: 8px; border: 1px dashed var(--brand);">
                                                    <div style="font-size: 9px; color: var(--brand); font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Tahap 1: Tanda Tangan</div>
                                                    <div style="display: flex; gap: 8px;">
                                                        <a href="{{ route('portal.pengajuanJudul.downloadSurat', $p->id) }}" target="_blank" class="btn btn-primary btn-sm" style="font-size: 10px; padding: 4px 8px; flex: 1;">Unduh</a>
                                                        @if(!$isStaff)
                                                            <button onclick="openUploadModal({{ $p->id }})" class="btn btn-secondary btn-sm" style="font-size: 10px; padding: 4px 8px; flex: 1; background: #fff;">Upload</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @elseif(!$p->is_kesediaan_valid)
                                                <div style="background: #FFFBEB; padding: 8px 12px; border-radius: 8px; border: 1px dashed #F59E0B;">
                                                    <div style="font-size: 9px; color: #D97706; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Tahap 2: Validasi Staff</div>
                                                    <div style="display: flex; align-items: center; gap: 8px;">
                                                        <a href="{{ asset('storage/' . $p->file_kesediaan) }}" target="_blank" class="btn btn-ghost btn-sm" style="font-size: 10px; padding: 4px 8px; flex: 1;">Lihat Doc</a>
                                                        @if($isStaff)
                                                            <form action="{{ route('portal.pengajuanJudul.validate', $p->id) }}" method="POST" style="flex: 1;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary btn-sm" style="font-size: 10px; padding: 4px 8px; width: 100%; background: #059669; border:none;">Validasi</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div style="background: #F0FDF4; padding: 8px 12px; border-radius: 8px; border: 1px solid #BBF7D0;">
                                                    <div style="font-size: 9px; color: #15803D; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">Terverifikasi</div>
                                                    <div style="display: flex; gap: 8px;">
                                                        <a href="{{ route('portal.pengajuanJudul.downloadSurat', $p->id) }}" target="_blank" class="btn btn-ghost btn-sm" style="font-size: 10px; padding: 4px 8px; flex: 1; color: #15803D; border-color: #BBF7D0;">
                                                            Download Surat
                                                        </a>
                                                        <a href="{{ asset('storage/' . $p->file_kesediaan) }}" target="_blank" class="btn btn-ghost btn-sm" style="font-size: 10px; padding: 4px 8px; flex: 1; color: #15803D; border-color: #BBF7D0;">
                                                            Arsip TTD
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
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
                                    </svg>
                                    <span>Tidak ada data pengajuan judul ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pengajuans->hasPages())
            <div style="padding: 16px 24px; background: var(--bg-page); display: flex; align-items: center; justify-content: space-between;">
                <span style="font-size: 12px; color: var(--text-muted);">
                    Menampilkan {{ $pengajuans->firstItem() }} sampai {{ $pengajuans->lastItem() }} dari {{ $pengajuans->total() }} data
                </span>
                <div class="pagination-links">
                    {{ $pengajuans->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>

</div>

{{-- Modal Generate Surat --}}
<div id="modalGenerate" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 550px;">
        <div class="modal-header">
            <h3 class="modal-title">Persetujuan & Penugasan Pembimbing</h3>
            <button class="modal-close" onclick="closeModal()">×</button>
        </div>
        <form id="formGenerate" action="" method="POST">
            @csrf
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div style="margin-bottom: 24px; background: var(--bg-page); padding: 16px; border-radius: 12px;">
                    <p style="font-size: 12px; margin-bottom: 4px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700;">Mahasiswa</p>
                    <p style="font-weight: 700; margin-bottom: 12px; color: var(--text-primary);" id="modalMahasiswa"></p>
                    <p style="font-size: 12px; margin-bottom: 4px; color: var(--text-secondary); text-transform: uppercase; font-weight: 700;">Judul yang Diajukan</p>
                    <p style="font-size: 14px; font-style: italic; font-weight: 500; color: var(--brand-dark);" id="modalJudul"></p>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">Nomor Surat Kesediaan Bimbingan</label>
                    <input type="text" name="no_surat" class="form-control" placeholder="Contoh: UN1.FP.1/PP.1.1/2026" required>
                </div>

                <div class="form-row form-row-2" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <label class="form-label">Pembimbing Utama (1)</label>
                        <select name="pembimbing1_id" class="form-control form-select" required>
                            <option value="">Pilih Dosen...</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pembimbing Pendamping (2)</label>
                        <select name="pembimbing2_id" class="form-control form-select">
                            <option value="">N/A (Kosongkan jika hanya 1 pembimbing)</option>
                            @foreach($dosens as $d)
                                <option value="{{ $d->id }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Judul disetujui dengan catatan revisi pada variabel penelitian..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Setujui & Terbitkan Surat</button>
            </div>
        </form>
    </div>
</div>

{{-- Upload Modal --}}
<div id="modalUpload" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 450px;">
        <div class="modal-header">
            <h3 class="modal-title">Upload Surat Kesediaan (TTD)</h3>
            <button class="modal-close" onclick="closeUploadModal()">×</button>
        </div>
        <form id="formUpload" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">
                    Silakan unggah Surat Kesediaan Bimbingan yang telah ditandatangani oleh Dosen Pembimbing dalam format PDF/JPG.
                </p>
                <div class="form-group">
                    <label class="form-label">Pilih File</label>
                    <input type="file" name="file_kesediaan" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeUploadModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Unggah Sekarang</button>
            </div>
        </form>
    </div>
</div>

{{-- WhatsApp Preview Modal --}}
<div id="waModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3 class="modal-title">Kirim Notifikasi WhatsApp</h3>
            <button class="modal-close" onclick="closeWaModal()">×</button>
        </div>
        <div class="modal-body">
            <div style="background: var(--bg-page); padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase;">Nomor HP Mahasiswa</div>
                <div id="wa_display_number" style="font-size: 15px; font-weight: 700; color: var(--brand-dark); margin-bottom: 16px;"></div>
                
                <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px; text-transform: uppercase;">Pratinjau Pesan</div>
                <div id="wa_display_message" style="font-size: 13px; line-height: 1.6; color: var(--text-primary); background: #fff; padding: 16px; border-radius: 12px; border: 1px solid var(--border); white-space: pre-wrap;"></div>
            </div>
            <p style="font-size: 11px; color: var(--text-muted); text-align: center;">Pesan akan dikirim melalui Gateway Wablas secara otomatis.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeWaModal()">Batal</button>
            <button type="button" id="btnSendWa" class="btn btn-primary" style="background: #25D366; border-color: #25D366;">
                Kirim Notifikasi Sekarang
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const modal = document.getElementById('modalGenerate');
    const form = document.getElementById('formGenerate');
    const modalMahasiswa = document.getElementById('modalMahasiswa');
    const modalJudul = document.getElementById('modalJudul');

    const waModal = document.getElementById('waModal');
    const waNumber = document.getElementById('wa_display_number');
    const waMessage = document.getElementById('wa_display_message');
    const btnSendWa = document.getElementById('btnSendWa');

    const p1Select = document.querySelector('select[name="pembimbing1_id"]');
    const p2Select = document.querySelector('select[name="pembimbing2_id"]');

    function filterOptions() {
        const val1 = p1Select.value;
        const val2 = p2Select.value;

        const selectors = [p1Select, p2Select];
        const values = [val1, val2];

        selectors.forEach((select, index) => {
            Array.from(select.options).forEach(opt => {
                if (opt.value === "") return;
                
                // Hide if selected in any OTHER dropdown
                let isMatch = false;
                values.forEach((v, vIndex) => {
                    if (index !== vIndex && opt.value === v && v !== "") {
                        isMatch = true;
                    }
                });

                opt.style.display = isMatch ? 'none' : 'block';
                opt.disabled = isMatch;
            });
        });
    }

    [p1Select, p2Select].forEach(s => s.addEventListener('change', filterOptions));

    document.querySelectorAll('.btn-generate').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const nim = this.dataset.nim;
            const nama = this.dataset.nama;
            const judul = this.dataset.judul;

            form.action = `/portal/pengajuan-judul/${id}/approve`;
            modalMahasiswa.innerText = `${nama} (${nim})`;
            modalJudul.innerText = `"${judul}"`;
            
            // Reset fields
            p1Select.value = "";
            p2Select.value = "";
            
            filterOptions();

            modal.style.display = 'flex';
        });
    });

    function openWaModal(id, phoneNumber, message) {
        waNumber.innerText = phoneNumber || 'Tidak ada nomor HP';
        waMessage.innerText = message;
        waModal.style.display = 'flex';
        
        btnSendWa.onclick = function() {
            btnSendWa.disabled = true;
            btnSendWa.innerText = 'Mengirim...';
            
            fetch(`/portal/pengajuan-judul/${id}/notify`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Notifikasi berhasil dikirim!');
                    closeWaModal();
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .finally(() => {
                btnSendWa.disabled = false;
                btnSendWa.innerText = 'Kirim Notifikasi Sekarang';
            });
        };
    }

    function closeWaModal() {
        waModal.style.display = 'none';
    }

    function openUploadModal(id) {
        const modalUpload = document.getElementById('modalUpload');
        const formUpload = document.getElementById('formUpload');
        formUpload.action = `/portal/pengajuan-judul/${id}/kesediaan`;
        modalUpload.style.display = 'flex';
    }

    function closeUploadModal() {
        document.getElementById('modalUpload').style.display = 'none';
    }

    function closeModal() {
        if(modal) modal.style.display = 'none';
    }

    window.onclick = function(e) {
        if (e.target === modal) closeModal();
        if (e.target === waModal) closeWaModal();
        if (e.target === document.getElementById('modalUpload')) closeUploadModal();
    };
</script>
@endpush
@endsection
