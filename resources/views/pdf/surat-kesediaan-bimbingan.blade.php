<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Kesediaan Bimbingan</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; margin: 0; padding: 0.5cm; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; position: relative; }
        .kop-surat h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .kop-surat h1 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .kop-surat p { margin: 0; font-size: 10pt; }
        .logo { position: absolute; left: 0; top: 0; width: 80px; }
        
        .isi-surat { margin: 0 1cm; }
        .nomor-surat { text-align: center; margin-bottom: 30px; }
        .nomor-surat h3 { margin: 0; text-decoration: underline; text-transform: uppercase; }
        
        .identitas-table { margin: 20px 0; width: 100%; border-collapse: collapse; }
        .identitas-table td { padding: 5px 0; vertical-align: top; }
        .identitas-table td:first-child { width: 180px; }
        .identitas-table td:nth-child(2) { width: 20px; }
        
        .penutup { margin-top: 30px; }
        
        .ttd-container { margin-top: 50px; float: right; width: 250px; text-align: left; }
        .ttd-box { position: relative; height: 100px; }
        .ttd-image { position: absolute; left: 0; top: 0; width: 150px; z-index: -1; }
        
        .footer { position: fixed; bottom: 0; width: 100%; font-size: 8pt; text-align: center; color: #666; }
        .clear { clear: both; }
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
        <div class="nomor-surat">
            <h3>SURAT KESEDIAAN BIMBINGAN SKRIPSI</h3>
            <p>Nomor: {{ $pengajuan->no_surat }}</p>
        </div>

        <p>Yang bertanda tangan di bawah ini, menerangkan bahwa judul skripsi mahasiswa berikut:</p>

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
                <td>{{ $prodi->nama }}</td>
            </tr>
            <tr>
                <td>Judul Skripsi</td>
                <td>:</td>
                <td><em>"{{ $pengajuan->judul }}"</em></td>
            </tr>
            <tr>
                <td>Pembimbing Utama (1)</td>
                <td>:</td>
                <td>{{ $pengajuan->pembimbing1->nama ?? '-' }}</td>
            </tr>
            @if($pengajuan->pembimbing2_id)
            <tr>
                <td>Pembimbing Pendamping (2)</td>
                <td>:</td>
                <td>{{ $pengajuan->pembimbing2->nama ?? '-' }}</td>
            </tr>
            @endif
        </table>

        <p>Berdasarkan hasil verifikasi berkas dan persyaratan akademik, maka judul tersebut dinyatakan <strong>DISETUJUI</strong> dan mahasiswa yang bersangkutan diperkenankan untuk melanjutkan ke tahapan bimbingan skripsi dengan pembimbing yang akan ditetapkan kemudian oleh Program Studi.</p>

        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="penutup">
            <p>Pontianak, {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <div class="ttd-container">
            <p>Ketua Program Studi,</p>
            <div class="ttd-box">
                @if($with_signature && $ttd_path)
                    <img src="{{ public_path('storage/' . $ttd_path) }}" class="ttd-image">
                @endif
            </div>
            <p><strong>{{ $ketua_nama ?? '..........................' }}</strong></p>
            <p>NIDN. {{ $ketua_nip ?? '..........................' }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer">
        Dokumen ini diterbitkan secara elektronik oleh SISFO FPST UPB.
    </div>
</body>
</html>
