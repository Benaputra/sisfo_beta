# Ringkasan Fitur Menu Skripsi, Praktek Lapang, dan Surat

Berikut adalah ringkasan fitur yang tersedia pada modul Skripsi, Praktek Lapang (Magang), dan Manajemen Surat dalam Sistem Informasi Akademik.

## Tabel Fitur Skripsi, Praktek Lapang & Surat

| Modul | Nama Fitur | Deskripsi Singkat | Aktor Utama |
| :--- | :--- | :--- | :--- |
| **Skripsi** | **Pendaftaran Sidang** | Mahasiswa mendaftar sidang skripsi setelah judul dan seminar disetujui. | Mahasiswa |
| | **Upload Berkas Syarat** | Unggah dokumen wajib: Bukti Bayar, Transkrip Nilai, dan Sertifikat TOEFL. | Mahasiswa |
| | **Plotting Penguji** | Penugasan Penguji 1 dan Penguji 2 oleh Staff/Kaprodi. | Staff/Kaprodi |
| | **Penjadwalan Sidang** | Input tanggal, waktu, dan lokasi ruangan pelaksanaan sidang skripsi. | Staff/Kaprodi |
| | **Dashboard Riwayat** | Monitoring status kelulusan/persetujuan sidang skripsi. | Mahasiswa & Staff |
| **Praktek Lapang** | **Pendaftaran Magang** | Registrasi lokasi magang/praktek lapang dan dosen pembimbing. | Mahasiswa |
| | **Manajemen Laporan** | Pencatatan detail lokasi dan judul laporan praktek lapang. | Mahasiswa & Staff |
| | **Status Tracking** | Rekapitulasi jumlah pendaftaran yang sedang proses atau selesai. | Semua Role |
| | **Filter Prodi** | Pencarian data praktek lapang berdasarkan Program Studi. | Staff |
| **Manajemen Surat** | **Sentralisasi Arsip** | Satu dashboard untuk seluruh jenis surat (Undangan, Izin, Kesediaan). | Staff |
| | **Linkage Dokumen** | Menghubungkan surat dengan data Seminar, Skripsi, atau Praktek Lapang. | Staff |
| | **PDF Generator** | Pembuatan surat resmi format PDF secara otomatis dari sistem. | Sistem |
| | **Preview & Cetak** | Fitur "Lihat Surat" untuk melihat pratinjau dokumen sebelum dicetak. | Staff |
| | **Auto-Fill Data** | Mengisi otomatis nama mahasiswa, NIM, dan judul pada badan surat. | Sistem |

## Poin Penting Implementasi

1.  **Prasyarat Skripsi:** Mahasiswa wajib melalui tahap **Pengajuan Judul** dan mendapatkan status 'Disetujui' sebelum pendaftaran Skripsi diizinkan.
2.  **Validasi Dokumen:** Menu riwayat Skripsi dan Praktek Lapang dilengkapi indikator warna untuk membedakan berkas yang sudah divalidasi dan yang belum.
3.  **Relasi Surat:** Setiap surat yang dibuat dapat ditelusuri keterkaitannya dengan data akademik mahasiswa, sehingga memudahkan pengarsipan digital.

---
*Laporan ini dihasilkan secara otomatis untuk merangkum fungsionalitas sistem yang telah diimplementasikan.*
