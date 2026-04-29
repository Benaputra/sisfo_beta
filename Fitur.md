# Daftar Fitur Frontend (Portal Akademik)

Dokumen ini berisi rincian fitur-fitur yang saat ini tersedia di frontend (Portal Mahasiswa & Staf) berdasarkan struktur menu dan *routing* aplikasi.

## 1. Autentikasi & Pengaturan Umum
*   **Login & Logout**: Autentikasi pengguna berdasarkan peran (*role*) dan identitas (Mahasiswa, Dosen, Sivitas/Staff).
*   **Update Theme**: Fitur pergantian tema tampilan (misalnya mode terang/gelap).

## 2. Dashboard
*   **Halaman Utama Dashboard (`/portal/dashboard`)**: Menampilkan ringkasan informasi dan notifikasi terbaru untuk pengguna yang sedang *login*.

## 3. Profil Mahasiswa
*   **Menu Mahasiswa (`/portal/mahasiswa`)**: 
    *   Melihat profil dan informasi detail mahasiswa.
    *   Akses dibatasi hanya untuk pengguna dengan *role* Mahasiswa.

## 4. Pengajuan Judul Skripsi
*   **Pendaftaran Pengajuan Judul (`/portal/pengajuan-judul`)**:
    *   Formulir pengajuan judul skripsi untuk mahasiswa.
    *   Pengecekan prasyarat (mahasiswa hanya bisa mengajukan jika belum ada pengajuan sebelumnya).
    *   Upload Bukti Pembayaran (diwajibkan khusus untuk mahasiswa angkatan 2020 ke bawah).
    *   Pencarian data pengajuan.
*   **Riwayat Pengajuan Judul (`/portal/riwayat-pengajuan-judul`)**:
    *   Melihat daftar dan status pengajuan judul skripsi.
    *   *Pencarian*: Filter berdasarkan judul, nama mahasiswa, atau NIM.
    *   *Edit & Hapus*: Mengubah atau menghapus data pengajuan judul.
    *   *Persetujuan (Approve)*: Fitur untuk staf menyetujui pengajuan judul.
    *   *Validasi Cepat*: Memvalidasi kelengkapan dokumen pengajuan.
    *   *Upload Dokumen*: Upload Surat Kesediaan Judul.
    *   *Download Dokumen*: Download Surat Kesediaan Bimbingan.
    *   *Notifikasi*: Mengirimkan notifikasi via WhatsApp kepada mahasiswa terkait status pengajuannya.

## 5. Seminar Proposal
*   **Pendaftaran Seminar (`/portal/seminar`)**:
    *   Formulir pendaftaran seminar proposal.
    *   Pemilihan Dosen Pembimbing 1 dan Pembimbing 2 (dengan validasi tidak boleh sama).
    *   Upload Bukti Pembayaran Seminar.
    *   Pencarian Mahasiswa berbasis AJAX (khusus staf yang mendaftarkan mahasiswa).
*   **Riwayat Seminar (`/portal/riwayat-seminar`)**:
    *   Melihat daftar pendaftaran seminar dan statusnya (Menunggu, Disetujui, Ditolak).
    *   *Edit & Hapus*: Mengelola data seminar, termasuk penentuan Dosen Penguji, tanggal, dan tempat seminar.
    *   *Upload Dokumen*: Mahasiswa dapat mengunggah ulang bukti bayar jika status masih "Menunggu". Mengunggah Surat Kesediaan Seminar.
    *   *Download Dokumen*:
        *   Generate dan Download **Surat Undangan Seminar** (Otomatis generate nomor surat jika belum ada).
        *   Generate dan Download **Surat Kesediaan Seminar**.
    *   *Validasi Cepat*: Staf memvalidasi kesediaan dan persyaratan.
    *   *Notifikasi*: Mengirimkan pesan/update jadwal seminar via WhatsApp.

## 6. Sidang Skripsi
*   **Pendaftaran Skripsi (`/portal/skripsi`)**:
    *   Formulir pendaftaran sidang skripsi.
    *   *Prasyarat*: Mahasiswa harus memiliki Judul yang sudah berstatus "Disetujui" terlebih dahulu.
    *   Pemilihan Dosen Pembimbing.
    *   Upload dokumen persyaratan: Bukti Bayar, Transkrip Nilai, dan Sertifikat TOEFL.
*   **Riwayat Skripsi (`/portal/riwayat-skripsi`)**:
    *   Melihat daftar pendaftaran sidang skripsi beserta status prosesnya.
    *   *Edit & Hapus*: Staf dapat menentukan Dosen Penguji 1 & 2, jadwal, tempat, dan memperbarui status sidang. Staf juga bisa input/update Nomor Surat Kesediaan secara manual.
    *   *Upload Dokumen*: Mahasiswa/Staf dapat mengunggah ulang dokumen persyaratan (Bukti bayar, Transkrip, TOEFL) dan Upload Surat Kesediaan Sidang.
    *   *Download Dokumen*: Generate dan Download Surat Undangan Skripsi & Surat Kesediaan Sidang.
    *   *Validasi Cepat*: Memverifikasi kelengkapan berkas skripsi.
    *   *Notifikasi*: Mengirim notifikasi jadwal/revisi via WhatsApp.

## 7. Praktek Lapang (Magang)
*   **Pendaftaran Praktek Lapang (`/portal/praktek-lapang`)**:
    *   Formulir pendaftaran kegiatan praktek lapang.
    *   Input lokasi praktek dan pemilihan Dosen Pembimbing.
    *   Upload Bukti Pembayaran dan Laporan Praktek Lapang.
*   **Riwayat Praktek Lapang (`/portal/riwayat-praktek-lapang`)**:
    *   Melihat daftar pendaftaran dan status praktek lapang.
    *   *Edit & Hapus*: Memperbarui data lokasi, pembimbing, dan dokumen (laporan/bukti bayar).
    *   *Download Dokumen*:
        *   Generate dan Download **Surat Kesediaan Praktek Lapang**.
        *   Generate dan Download **Surat Jalan Praktek Lapang** (Dilengkapi otomatisasi penomoran surat lanjutan).

## 8. Manajemen Surat
*   **Riwayat Surat (`/portal/riwayat-surat`)**:
    *   Sistem terpusat untuk melihat riwayat surat yang pernah di-generate oleh sistem (Surat Undangan, Kesediaan, Surat Jalan).
    *   Melihat detail surat (*View Surat*).

---
*Catatan: Hak akses (Mahasiswa vs. Staf/Kaprodi) pada fitur-fitur yang berkaitan dengan Edit, Hapus, Approve, dan Validasi dibatasi secara ketat di sisi backend (Controller).*
