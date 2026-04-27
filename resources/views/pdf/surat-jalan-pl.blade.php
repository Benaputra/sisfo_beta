<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Jalan Praktek Lapang</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.5; color: #000; margin: 0; padding: 0.5cm; }
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

        .ttd-section { margin-top: 40px; }
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
            <h3>SURAT JALAN PRAKTEK LAPANG</h3>
            @if(isset($surat))
                <p>Nomor: {{ $surat->no_surat }}</p>
            @endif
        </div>

        <p>Yang bertanda tangan di bawah ini, Ketua Program Studi Fakultas Pertanian, Sains dan Teknologi
        Universitas Panca Bhakti Pontianak, dengan ini menerangkan bahwa mahasiswa yang tersebut di bawah ini:</p>

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
                <td>Semester</td>
                <td>:</td>
                <td>{{ $mahasiswa->semester ?? '-' }}</td>
            </tr>
        </table>

        <p>Adalah benar mahasiswa kami yang sedang menjalankan kegiatan <strong>Praktek Lapang</strong> di:</p>

        <table class="identitas-table">
            <tr>
                <td>Lokasi Praktek</td>
                <td>:</td>
                <td><strong>{{ $praktekLapang->lokasi }}</strong></td>
            </tr>
            <tr>
                <td>Dosen Pembimbing</td>
                <td>:</td>
                <td>{{ $praktekLapang->dosenPembimbing->nama ?? '-' }}</td>
            </tr>
        </table>

        <p>Mohon kiranya Bapak/Ibu dapat memberikan izin dan kemudahan kepada mahasiswa yang bersangkutan
        dalam menjalankan kegiatan Praktek Lapang di instansi yang Bapak/Ibu pimpin.</p>

        <p>Demikian Surat Jalan ini kami buat, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        <div class="ttd-section">
            <table class="ttd-table">
                <tr>
                    <td></td>
                    <td style="text-align:center;">
                        <p>Pontianak, {{ now()->isoFormat('D MMMM Y') }}</p>
                        <p>Ketua Program Studi,</p>
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
        Dokumen ini diterbitkan secara resmi oleh Fakultas Pertanian, Sains dan Teknologi – UPB Pontianak.
    </div>
</body>
</html>
