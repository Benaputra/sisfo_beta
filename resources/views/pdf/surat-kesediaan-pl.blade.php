<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Kesediaan Praktek Lapang</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.4; color: #000; margin: 0; padding: 0.5cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0; font-size: 13pt; text-transform: uppercase; }
        .kop-surat h1 { margin: 0; font-size: 15pt; text-transform: uppercase; }
        .kop-surat p  { margin: 0; font-size: 9pt; }

        .isi-surat { margin: 0 0.5cm; }
        .judul-surat { text-align: center; margin-bottom: 20px; }
        .judul-surat h3 { margin: 0; text-decoration: underline; text-transform: uppercase; }
        .judul-surat p  { margin: 0; font-size: 10pt; }

        .identitas-table { margin: 15px 0; width: 100%; border-collapse: collapse; }
        .identitas-table td { padding: 3px 0; vertical-align: top; }
        .identitas-table td:first-child { width: 160px; }
        .identitas-table td:nth-child(2) { width: 15px; }

        .ttd-section { margin-top: 30px; }
        .ttd-table { width: 100%; border-collapse: collapse; }
        .ttd-table td { width: 50%; vertical-align: top; height: 120px; }

        .footer { position: fixed; bottom: 0; width: 100%; font-size: 8pt; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h2>UNIVERSITAS PANCA BHAKTI</h2>
        <h1>FAKULTAS PERTANIAN, SAINS DAN TEKNOLOGI</h1>
        <p>Jalan Komodor Yos Sudarso No. 1 Pontianak, Kalimantan Barat</p>
        <p>Email: fpst@upb.ac.id | Website: fpst.upb.ac.id</p>
    </div>

    <div class="isi-surat">
        <div class="judul-surat">
            <h3>SURAT KESEDIAAN PEMBIMBINGAN PRAKTEK LAPANG</h3>
            @if(isset($surat))
                <p>Nomor: {{ $surat->no_surat }}</p>
            @endif
        </div>

        <p>Yang bertanda tangan di bawah ini, menyatakan bersedia menjadi Dosen Pembimbing Praktek Lapang untuk mahasiswa berikut:</p>

        <table class="identitas-table">
            <tr>
                <td>Nama Mahasiswa</td>
                <td>:</td>
                <td><strong>{{ $mahasiswa->nama }}</strong></td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $prodi->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Lokasi Praktek</td>
                <td>:</td>
                <td><strong>{{ $praktekLapang->lokasi }}</strong></td>
            </tr>
        </table>

        <p>Demikian surat kesediaan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="ttd-section">
            <p>Pontianak, ..................................... 20...</p>
            <table class="ttd-table">
                <tr>
                    <td>
                        <p>Dosen Pembimbing PL,</p>
                        <br><br><br><br>
                        <p><strong>{{ $praktekLapang->dosenPembimbing->nama ?? '(...........................................)' }}</strong></p>
                        <p>NIDN. {{ $praktekLapang->dosenPembimbing->nidn ?? '..........................' }}</p>
                    </td>
                    <td>
                        <p>Menyetujui,<br>Ketua Program Studi</p>
                        <div style="height:80px; text-align:center; padding-top:5px;">
                            @if(!empty($with_signature) && !empty($ttd_path))
                                <img src="{{ public_path('storage/' . $ttd_path) }}" style="width:120px;">
                            @endif
                        </div>
                        <p><strong>{{ $ketua_nama ?? '..........................' }}</strong></p>
                        <p>NIDN. {{ $ketua_nip ?? '..........................' }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        Cetak surat ini dan mintalah tanda tangan Dosen Pembimbing sebelum diunggah kembali ke sistem.
    </div>
</body>
</html>
