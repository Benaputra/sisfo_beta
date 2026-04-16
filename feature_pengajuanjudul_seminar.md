# Ringkasan Fitur Menu Pengajuan Judul dan Seminar

Berikut adalah ringkasan fitur yang tersedia pada modul Pengajuan Judul Skripsi dan Pendaftaran Seminar dalam Sistem Informasi Akademik.

## Tabel Fitur Pengajuan Judul & Seminar

| Modul | Nama Fitur | Deskripsi Singkat | Aktor Utama |
| :--- | :--- | :--- | :--- |
| **Pengajuan Judul** | **Form Pengajuan Mandiri** | Mahasiswa mengajukan judul skripsi beserta upload bukti pembayaran. | Mahasiswa |
| | **Registrasi Kolektif** | Staff atau Kaprodi dapat mendaftarkan judul untuk mahasiswa tertentu. | Staff/Kaprodi |
| | **Plotting Pembimbing** | Penentuan Dosen Pembimbing Utama (1) dan Pendamping (2) saat persetujuan. | Staff/Kaprodi |
| | **Oto-Generate Surat** | Sistem menerbitkan Surat Kesediaan Bimbingan (PDF) dengan nomor surat resmi. | Sistem |
| | **Digital Signature Flow** | Alur unduh surat -> TTD Dosen -> Unggah scan -> Validasi Staff. | Mahasiswa & Staff |
| | **Notifikasi WA Otomatis** | Pengiriman pesan WhatsApp ke mahasiswa saat judul disetujui melalui Gateway. | Staff |
| | **Auto-Sync Seminar** | Judul yang sudah divalidasi surat kesediaannya otomatis terdaftar di menu Seminar. | Sistem |
| | **Monitoring History** | Dashboard pelacakan status (Pending/Disetujui) dengan fitur pencarian. | Mahasiswa & Staff |
| **Seminar** | **Pendaftaran Seminar** | Input pendaftaran seminar (Judul otomatis sinkron dari pengajuan judul). | Mahasiswa & Staff |
| | **Penjadwalan (Scheduling)** | Penentuan tanggal, waktu, dan lokasi/ruang pelaksanaan seminar. | Staff/Kaprodi |
| | **Plotting Tim Penguji** | Penugasan Dosen Penguji untuk setiap sesi seminar. | Staff/Kaprodi |
| | **Verifikasi Dokumen** | Validasi bukti bayar seminar dan keabsahan surat kesediaan bimbingan. | Staff |
| | **Penerbitan Undangan** | Generate Surat Undangan Seminar (PDF) jika semua syarat administrasi terpenuhi. | Staff/Sistem |
| | **Smart WA Broadcast** | Notifikasi dinamis berdasarkan status (Validasi, Instruksi TTD, atau Undangan Siap). | Staff |
| | **Manajemen Riwayat** | Rekapitulasi pendaftaran dengan filter status (Menunggu, Disetujui, Ditolak). | Mahasiswa & Staff |
| | **Sinkronisasi Data** | Fitur hapus data yang saling terintegrasi antara Seminar dan Pengajuan Judul. | Staff |

## Alur Integrasi Utama (Workflow)

1.  **Tahap Judul:** Mahasiswa mengajukan judul -> Disetujui Staff -> Pembimbing Ditentukan -> Surat Kesediaan Terbit.
2.  **Tahap Validasi:** Mahasiswa upload scan surat kesediaan bertanda tangan -> Staff Validasi.
3.  **Tahap Seminar:** Setelah validasi judul, data otomatis masuk ke antrean Seminar -> Staff menentukan Penguji & Jadwal -> Surat Undangan Seminar terbit.

---
*Laporan ini dihasilkan secara otomatis untuk merangkum fungsionalitas sistem yang telah diimplementasikan.*
