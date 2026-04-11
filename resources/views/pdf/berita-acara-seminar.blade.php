@extends('pdf.layout')

@section('content')
<h3 style="text-align: center; text-decoration: underline;">BERITA ACARA SEMINAR</h3>

<p>Pada hari ini {{ $seminar->tanggal->format('l') }} tanggal {{ $seminar->tanggal->format('d F Y') }} bertempat di {{ $seminar->tempat }}, telah dilaksanakan Seminar oleh:</p>

<table class="table" style="margin-left: 20px;">
    <tr>
        <td width="30%">Nama</td>
        <td width="2%">:</td>
        <td>{{ $mahasiswa->nama }}</td>
    </tr>
    <tr>
        <td>NIM</td>
        <td>:</td>
        <td>{{ $mahasiswa->nim }}</td>
    </tr>
    <tr>
        <td>Judul Seminar</td>
        <td>:</td>
        <td>{{ $seminar->judul }}</td>
    </tr>
</table>

<p>Dengan susunan tim penguji sebagai berikut:</p>
<table border="1" class="table" style="border: 1px solid #000;">
    <thead>
        <tr>
            <th height="30">Posisi</th>
            <th>Nama Dosen</th>
            <th>Tanda Tangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td height="50">Pembimbing 1</td>
            <td>{{ $seminar->pembimbing1->nama }}</td>
            <td>1.</td>
        </tr>
        <tr>
            <td height="50">Pembimbing 2</td>
            <td>{{ $seminar->pembimbing2->nama ?? '-' }}</td>
            <td>2.</td>
        </tr>
        <tr>
            <td height="50">Penguji 1</td>
            <td>{{ $seminar->pengujiSeminar->nama ?? '-' }}</td>
            <td>3.</td>
        </tr>
        <tr>
            <td height="50">Penguji 2</td>
            <td>{{ $seminar->penguji2->nama ?? '-' }}</td>
            <td>4.</td>
        </tr>
    </tbody>
</table>

<p style="margin-top: 30px;">Hasil Seminar: [ LAYAK / TIDAK LAYAK ] dengan revisi / tanpa revisi.</p>

<div class="signature-area">
    <div class="signature-box">
        <p>Yogyakarta, .....................</p>
        <p>Sekretaris Tim Penguji,</p>
        <div class="signature-space"></div>
        <p>( {{ $seminar->pembimbing1->nama }} )</p>
    </div>
    <div class="clear"></div>
</div>
@endsection
