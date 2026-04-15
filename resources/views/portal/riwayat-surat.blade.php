@extends('layouts.app')

@section('title', 'Riwayat Surat')

@section('topbar-nav')
    <a href="#">Home</a>
    <a href="{{ route('portal.riwayatSurat') }}" class="active">Surat</a>
    <a href="{{ route('portal.riwayatSeminar') }}">Seminar</a>
@endsection

@section('content')
<div class="animate-fadein">

    {{-- ── Header Section ── --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
        <div>
            <div class="section-label" style="display: inline-block; margin-bottom: 12px; padding: 2px 10px;">PORTAL AKADEMIK</div>
            <h1 class="page-title">Riwayat <span>Surat</span></h1>
            <p class="page-desc">Kelola dan pantau seluruh arsip surat menyurat akademik Anda. Di sini Anda dapat melihat nomor surat, tujuan, dan keterkaitannya dengan pengajuan akademik.</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="openCreateModal()" style="padding: 12px 24px; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Buat Surat Baru
            </button>
        </div>
    </div>

    {{-- ── Filter & Search Section ── --}}
    <form action="{{ route('portal.riwayatSurat') }}" method="GET" style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 24px;">
        <div class="card" style="padding: 16px; display: flex; align-items: center; gap: 12px; background: var(--bg-page);">
            <div class="topbar-search" style="width: 100%; background: #fff; flex: 1;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <circle cx="6" cy="6" r="4.5" stroke="#9CA3AF" stroke-width="1.5"/>
                    <path d="M10 10l2.5 2.5" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor surat atau jenis surat..." style="border: none; background: transparent; outline: none; width: 100%; font-size: 13px;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm" style="padding: 10px 24px;">Cari</button>
        </div>
    </form>

    {{-- ── Main Table Card ── --}}
    <div class="card" style="overflow: hidden;">
        <div style="overflow-x: auto;">
            <table class="w-full text-left" style="border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--bg-page);">
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">No</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Jenis Surat</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Nomor Surat</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tujuan / Penerima</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Relasi Dokumen</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border);">Tanggal Dibuat</th>
                        <th style="padding: 16px 24px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-secondary); border-bottom: 1px solid var(--border); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse ($surats as $surat)
                        <tr style="transition: background 0.2s;">
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 700; color: var(--text-primary);">{{ ($surats->currentPage() - 1) * $surats->perPage() + $loop->iteration }}</div>
                            </td>   
                            <td style="padding: 16px 24px;">
                                <div style="font-weight: 700; color: var(--brand-dark);">{{ $surat->jenis_surat }}</div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="font-family: monospace; font-size: 13px; font-weight: 600; color: var(--text-primary);">{{ $surat->no_surat }}</div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="font-size: 13px; font-weight: 600;">{{ $surat->tujuan_surat }}</div>
                            </td>
                            <td style="padding: 16px 24px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    @foreach($surat->seminars as $sem)
                                        <div class="badge" style="background: #E0F2FE; color: #0369A1; font-size: 10px; padding: 2px 8px;">
                                            Seminar: {{ $sem->mahasiswa->nama ?? 'N/A' }}
                                        </div>
                                    @endforeach
                                    @foreach($surat->skripsis as $skr)
                                        <div class="badge" style="background: #FEF3C7; color: #92400E; font-size: 10px; padding: 2px 8px;">
                                            Skripsi: {{ $skr->mahasiswa->nama ?? 'N/A' }}
                                        </div>
                                    @endforeach
                                    @foreach($surat->praktekLapangs as $pl)
                                        <div class="badge" style="background: #F1F5F9; color: #475569; font-size: 10px; padding: 2px 8px;">
                                            Praktek: {{ $pl->mahasiswa->nama ?? 'N/A' }}
                                        </div>
                                    @endforeach
                                    @if($surat->seminars->isEmpty() && $surat->skripsis->isEmpty() && $surat->praktekLapangs->isEmpty())
                                        <span style="font-size: 11px; color: var(--text-muted); font-style: italic;">Umum</span>
                                    @endif
                                </div>
                            </td>
                            <td style="padding: 16px 24px; font-size: 13px; color: var(--text-secondary);">
                                {{ $surat->created_at->format('d M Y') }}
                            </td>
                            <td style="padding: 16px 24px; text-align: right;">
                                {{-- Actions --}}
                                <a href="{{ route('portal.surat.view', $surat->id) }}" target="_blank" class="btn btn-primary btn-sm" style="padding: 6px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-radius: 6px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                                    Lihat Surat
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 48px; text-align: center; color: var(--text-muted);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                    </svg>
                                    <span>Tidak ada data surat ditemukan</span>
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
                Menampilkan {{ $surats->firstItem() ?? 0 }} sampai {{ $surats->lastItem() ?? 0 }} dari {{ $surats->total() }} surat
            </span>
            <div class="pagination-links">
                {{ $surats->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div id="createModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:10000; align-items:center; justify-content:center;">
        <div class="card" style="width:100%; max-width:600px; padding:32px; background:var(--bg-card); overflow-y: auto; max-height: 90vh;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                <h2 style="font-size:18px; font-weight:700;">Buat Surat Baru</h2>
                <button onclick="closeModal()" style="border:none; background:none; cursor:pointer; font-size:24px;">&times;</button>
            </div>
            <form action="{{ route('portal.surat.store') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label">Jenis Surat</label>
                    <select name="jenis_surat" class="form-control form-select" required onchange="toggleRelasiFields(this.value)">
                        <option value="">Pilih Jenis Surat</option>
                        <option value="Undangan Seminar">Undangan Seminar</option>
                        <option value="Undangan Skripsi">Undangan Skripsi</option>
                        <option value="Surat Izin Mahasiswa">Surat Izin Mahasiswa</option>
                        <option value="Undangan Praktek Lapang">Undangan Praktek Lapang</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div class="form-row form-row-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 001/FP-UPB/2026" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tujuan / Penerima</label>
                        <input type="text" name="tujuan_surat" class="form-control" placeholder="Nama Mahasiswa / Instansi" required>
                    </div>
                </div>

                <div id="relasi_section" style="background: var(--bg-page); padding: 16px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="font-size: 11px; font-weight: 700; color: var(--text-secondary); margin-bottom: 12px; text-transform: uppercase;">Hubungkan dengan Data Akademik</div>
                    
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label">Tipe Relasi</label>
                        <select name="related_type" id="related_type" class="form-control form-select" onchange="updateRelatedOptions(this.value)">
                            <option value="">-- Tanpa Relasi --</option>
                            <option value="seminar">Seminar</option>
                            <option value="skripsi">Skripsi</option>
                            <option value="praktek_lapang">Praktek Lapang</option>
                        </select>
                    </div>

                    <div class="form-group" id="container_related_id" style="display: none;">
                        <label class="form-label" id="label_related_id">Pilih Item</label>
                        <select name="related_id" id="related_id" class="form-control form-select">
                            {{-- Dynamically filled via JS --}}
                        </select>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px;">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const dataSeminars = @json($seminars);
    const dataSkripsis = @json($skripsis);
    const dataPrakteks = @json($prakteks);

    function openCreateModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function toggleRelasiFields(jenis) {
        const relatedType = document.getElementById('related_type');
        if (jenis.includes('Seminar')) {
            relatedType.value = 'seminar';
        } else if (jenis.includes('Skripsi')) {
            relatedType.value = 'skripsi';
        } else if (jenis.includes('Praktek')) {
            relatedType.value = 'praktek_lapang';
        }
        updateRelatedOptions(relatedType.value);
    }

    function updateRelatedOptions(type) {
        const container = document.getElementById('container_related_id');
        const select = document.getElementById('related_id');
        const label = document.getElementById('label_related_id');
        
        select.innerHTML = '<option value="">Pilih data yang sesuai...</option>';
        
        if (!type) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        let items = [];
        
        if (type === 'seminar') {
            label.innerText = 'Pilih Seminar';
            items = dataSeminars;
        } else if (type === 'skripsi') {
            label.innerText = 'Pilih Skripsi';
            items = dataSkripsis;
        } else if (type === 'praktek_lapang') {
            label.innerText = 'Pilih Praktek Lapang';
            items = dataPrakteks;
        }

        items.forEach(item => {
            const name = item.mahasiswa ? item.mahasiswa.nama : 'Unknown';
            const detail = item.judul || item.lokasi || '';
            const option = document.createElement('option');
            option.value = item.id;
            option.innerText = `${item.nim} - ${name} (${detail.substring(0, 30)}...)`;
            select.appendChild(option);
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('createModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endpush
@endsection
