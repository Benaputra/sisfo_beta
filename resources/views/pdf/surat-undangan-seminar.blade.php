@extends('pdf.layout')

@section('content')
<div style="text-align: right;">Yogyakarta, {{ now()->format('d F Y') }}</div>

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
        <td><strong>Undangan Seminar Proyek Akhir / Skripsi</strong></td>
    </tr>
</table>

<p style="margin-top: 20px;">
    Yth. Bapak/Ibu Dosen Penguji & Pembimbing<br>
    Fakultas Pertanian UGM<br>
    Yogyakarta
</p>

<p>Dengan hormat,</p>
<p>Mengharap kehadiran Bapak/Ibu pada pelaksanaan Seminar yang akan dilaksanakan pada:</p>

<table class="table" style="margin-left: 20px;">
    <tr>
        <td width="30%">Nama Mahasiswa</td>
        <td width="2%">:</td>
        <td>{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</td>
    </tr>
    <tr>
        <td>Judul</td>
        <td>:</td>
        <td>{{ $seminar->judul }}</td>
    </tr>
    <tr>
        <td>Hari, Tanggal</td>
        <td>:</td>
        <td>{{ $seminar->tanggal->format('l, d F Y') }}</td>
    </tr>
    <tr>
        <td>Waktu / Tempat</td>
        <td>:</td>
        <td>{{ $seminar->tempat }}</td>
    </tr>
</table>

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
        <p>NIP. {{ $ketua_nip ?? '.........................' }}</p>
    </div>
    <div class="clear"></div>
</div>
@endsection
