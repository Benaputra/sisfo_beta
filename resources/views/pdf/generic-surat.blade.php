@extends('pdf.layout')

@section('content')
<div style="text-align: right;">Pontianak, {{ $surat->created_at->format('d F Y') }}</div>

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
        <td><strong>{{ $surat->jenis_surat }}</strong></td>
    </tr>
</table>

<p style="margin-top: 20px;">
    Yth. Bapak/Ibu Dosen/Mahasiswa/Pihak Terkait<br>
    Fakultas Pertanian, Sains dan Teknologi UPB<br>
    Pontianak
</p>

<p>Dengan hormat,</p>
<p>Sehubungan dengan pelaksanaan kegiatan akademik, bersama ini kami sampaikan informasi mengenai:</p>

<table class="table" style="margin-left: 20px;">
    <tr>
        <td width="30%">Tujuan / Nama</td>
        <td width="2%">:</td>
        <td>{{ $surat->tujuan_surat }}</td>
    </tr>
    @if($related_data)
        @if(isset($related_data['mahasiswa']))
        <tr>
            <td>Mahasiswa</td>
            <td>:</td>
            <td>{{ $related_data['mahasiswa']->nama }} ({{ $related_data['mahasiswa']->nim }})</td>
        </tr>
        @endif
        @if(isset($related_data['judul']) || isset($related_data['lokasi']))
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $related_data['judul'] ?? $related_data['lokasi'] }}</td>
        </tr>
        @endif
        @if(isset($related_data['tanggal']))
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td>{{ \Carbon\Carbon::parse($related_data['tanggal'])->format('l, d F Y') }}</td>
        </tr>
        @endif
    @endif
</table>

<p style="margin-top: 20px;">Demikian surat ini kami sampaikan untuk dapat dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

<div class="signature-area">
    <div class="signature-box">
        <p>Ketua Program Studi,</p>
        <div class="signature-space">
            @if($ttd_path)
                <img src="{{ public_path('storage/' . $ttd_path) }}" class="signature-img">
            @endif
        </div>
        <p><strong>({{ $ketua_nama ?? '.........................' }})</strong></p>
        <p>NIP/NIDN. {{ $ketua_nip ?? '.........................' }}</p>
    </div>
    <div class="clear"></div>
</div>
@endsection
