@extends('pdf.layout')

@section('content')
<div style="text-align: right;">Pontianak, {{ now()->format('d F Y') }}</div>

<table class="table" style="margin-top: 0;">
    <tr>
        <td width="15%">Nomor</td>
        <td width="2%">:</td>
        <td>{{ $surat->no_surat }}</td>
    </tr>
    <tr>
        <td>Lampiran</td>
        <td>:</td>
        <td>-</td>
    </tr>
    <tr>
        <td>Perihal</td>
        <td>:</td>
        <td><strong>Undangan Sidang Skripsi</strong></td>
    </tr>
</table>

<p style="margin-top: 20px;">
    Yth. Bapak/Ibu Tim Sidang Skripsi<br>
    Fakultas Pertanian, Sains dan Teknologi UPB<br>
    Pontianak
</p>

<p>Dengan hormat,</p>
<p>Mengharap kehadiran Bapak/Ibu pada pelaksanaan Sidang Skripsi yang akan dilaksanakan pada:</p>

<table class="table" style="margin-left: 20px;">
    <tr>
        <td width="30%">Nama Mahasiswa</td>
        <td width="2%">:</td>
        <td>{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</td>
    </tr>
    <tr>
        <td>Judul Skripsi</td>
        <td>:</td>
        <td><em>"{{ $skripsi->judul }}"</em></td>
    </tr>
    <tr>
        <td>Hari, Tanggal</td>
        <td>:</td>
        <td>{{ $skripsi->tanggal ? $skripsi->tanggal->format('l, d F Y') : '..........................' }}</td>
    </tr>
    <tr>
        <td>Waktu / Tempat</td>
        <td>:</td>
        <td>{{ $skripsi->tempat ?? '..........................' }}</td>
    </tr>
</table>

<p>Tim Sidang Skripsi:</p>
<ol>
    <li>Pembimbing 1: {{ $skripsi->pembimbing1->nama ?? '-' }}</li>
    <li>Pembimbing 2: {{ $skripsi->pembimbing2->nama ?? '-' }}</li>
    <li>Penguji 1: {{ $skripsi->penguji1->nama ?? '-' }}</li>
    <li>Penguji 2: {{ $skripsi->penguji2->nama ?? '-' }}</li>
</ol>

<p>Demikian undangan ini kami sampaikan, atas kehadiran dan kerjasamanya diucapkan terima kasih.</p>

<div class="signature-area">
    <div class="signature-box">
        <p>Ketua Program Studi,</p>
        <div class="signature-space">
            @if($with_signature && $ttd_path)
                <img src="{{ public_path('storage/' . $ttd_path) }}" class="signature-img">
            @endif
        </div>
        <p><strong>({{ $ketua_nama ?? '.........................' }})</strong></p>
        <p>NIDN. {{ $ketua_nip ?? '.........................' }}</p>
    </div>
    <div class="clear"></div>
</div>
@endsection
