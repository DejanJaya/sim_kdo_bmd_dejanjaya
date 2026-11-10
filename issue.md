# Project Plan & Issue Specification: Aplikasi Pengelolaan Kendaraan Dinas Operasional (SI-KDO BMD)

Dokumen ini berisi rencana kerja (*high-level planning*) dan spesifikasi kebutuhan untuk membangun **Aplikasi Pengelolaan Kendaraan Dinas Operasional (KDO)** milik Perangkat Daerah sebagai bagian dari pengelolaan **Barang Milik Daerah (BMD)**. Dokumen ini dirancang sebagai panduan utama bagi Programmer atau AI Agent pelaksana untuk mengimplementasikan aplikasi secara terstruktur.

---

## 1. Gambaran Umum & Tujuan Aplikasi

Aplikasi ini bertujuan untuk mendigitalisasi proses pengelolaan Kendaraan Dinas Operasional (KDO) di lingkungan pemerintah daerah, dengan fokus pada:
1. **Pendataan Inventaris KDO**: Mencatat seluruh data identitas dan spesifikasi kendaraan dinas secara terpusat.
2. **Pemantauan Kondisi Fisik**: Mengetahui status/kondisi terkini dari setiap kendaraan (`Baik`, `Rusak Ringan`, `Rusak Berat`) serta masa berlaku pajak/STNK.
3. **Akuntabilitas Penanggung Jawab**: Mencatat Pegawai Negeri Sipil (PNS) dan Perangkat Daerah (PD) yang bertanggung jawab atas penggunaan masing-masing kendaraan.

---

## 2. Aturan Teknis & Batasan Dependency (WAJIB DITAATI)

Pelaksana **wajib** mematuhi spesifikasi teknologi dan batasan berikut selama proses pengembangan:

### Tech Stack Utama
- **Backend Framework**: Laravel 12 (PHP)
- **Database**: MySQL
- **Frontend Template**: AdminLTE versi 3 (**Wajib menggunakan asset lokal** yang disimpan di direktori `public/`, dipanggil menggunakan helper `asset()`)
- **Frontend Scripting**: Vanilla JavaScript & jQuery (menggunakan AJAX untuk komunikasi dengan REST API)

### Batasan & Larangan Dependency
- **DILARANG** menggunakan Tailwind CSS.
- **DILARANG** menggunakan framework SPA/reaktif seperti React atau Vue.
- **DILARANG** menggunakan Vite untuk mengintegrasikan AdminLTE (hapus atau abaikan pemanggilan `@vite` pada layout Blade, gunakan tag `<link>` dan `<script>` standar ke folder `public/`).
- **Wajib Menggunakan Asset Lokal** untuk AdminLTE v3 beserta library pendukung UI (jQuery, Bootstrap 4, FontAwesome, DataTables, Select2, SweetAlert2, Chart.js).
- **JANGAN** menambahkan package/dependency baru (baik melalui Composer maupun NPM) tanpa persetujuan eksplisit dari pemilik proyek.

---

## 3. Entitas Data & Relasi (High-Level Schema)

Aplikasi memiliki **3 Entitas Utama** dan **Entitas Pendukung (Inovasi)** untuk memperkuat fungsionalitas pengelolaan BMD:

### A. Entitas Utama

1. **Perangkat Daerah (PD)**
   - Menyimpan data instansi/OPD pemilik atau pengguna KDO.
   - **Atribut Utama**: Kode PD, Nama Perangkat Daerah, Singkatan, Alamat, Kontak/Telepon, Nama Kepala Dinas.
   - **Data Awal Wajib (Real Seeder)**:
     - Dinas Pendidikan
     - Dinas Kesehatan
     - Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)
     - *(Dapat ditambahkan PD riil lainnya sebagai pelengkap)*

2. **Pegawai Negeri Sipil (PNS)**
   - Menyimpan data pegawai yang menjadi penanggung jawab / pemegang kendaraan.
   - **Atribut Utama**: NIP (unik), Nama Lengkap, Jabatan, Pangkat/Golongan, Nomor Telepon/HP, Status Pegawai, serta relasi ke **Perangkat Daerah (PD)**.

3. **Kendaraan Dinas Operasional (KDO)**
   - Menyimpan data induk kendaraan dinas.
   - **Atribut Utama**:
     - Nomor Polisi (unik)
     - Kode Barang / NUP (standar BMD)
     - Kategori / Jenis Kendaraan (Roda 2, Roda 4, Roda 6, dll.)
     - Merk Kendaraan
     - Tipe / Model Kendaraan
     - Tahun Produksi / Pengadaan
     - Warna Kendaraan
     - Nomor Rangka, Nomor Mesin, & Nomor BPKB
     - Tanggal Jatuh Tempo Pajak / STNK
     - Kondisi Kendaraan (`Baik`, `Rusak Ringan`, `Rusak Berat`)
     - Status Penggunaan (`Digunakan`, `Tersedia/Pool`, `Dalam Perbaikan`)
     - Foto Kendaraan & Keterangan
     - Relasi ke **Perangkat Daerah (PD)** dan **PNS Penanggung Jawab**.

### B. Entitas & Fitur Inovasi Tambahan (Nilai Tambah)

Untuk meningkatkan nilai fungsionalitas pengelolaan BMD, tambahkan fitur/entitas relevan berikut:
1. **Riwayat Pemeliharaan & Perubahan Kondisi (Log Servis/Kondisi)**:
   - Mencatat riwayat servis berkala, perbaikan, tanggal pemeliharaan, biaya, dan perubahan status kondisi kendaraan (misal dari `Rusak Ringan` menjadi `Baik`).
2. **Riwayat Penugasan / BAST (Berita Acara Serah Terima) Pemegang KDO**:
   - Mencatat jejak histori pergantian PNS penanggung jawab kendaraan agar histori pemegang sebelumnya tetap terdokumentasi.
3. **Autentikasi Pengguna (User/Admin)**:
   - Sistem login untuk pengelola BMD agar data dan aksi perubahan terlindungi.

---

## 4. Spesifikasi Fungsional: Backend (REST API)

Seluruh operasi pengolahan data utama wajib disediakan melalui **REST API** yang bersih, terstandarisasi, dan aman:

1. **Perancangan Endpoint**:
   - Gunakan prefix `/api/v1/...` atau `/api/...` dengan penamaan resource yang konsisten (`/perangkat-daerah`, `/pns`, `/kdo`, `/riwayat-pemeliharaan`, `/dashboard/summary`).
   - Implementasikan fungsi **CRUD Lengkap**:
     - `GET` (List dengan dukungan filter/search & Detail berdasarkan ID)
     - `POST` (Create data baru)
     - `PUT/PATCH` (Update data yang tersimpan)
     - `DELETE` (Hapus data dengan pengecekan relasi/integritas referensial)
2. **Standarisasi Response JSON**:
   - Buat format response yang seragam (`status`/`success`, `message`, `data`, `errors`, dan `meta` jika menggunakan paginasi).
3. **Validasi & Error Handling**:
   - Gunakan Laravel Form Request untuk validasi input (contoh: format NIP, keunikan Nomor Polisi, validasi enum kondisi kendaraan).
   - Tangani error secara rapi dengan kode HTTP yang tepat (`200`, `201`, `400`, `401`, `404`, `409 Conflict` saat menghapus PD/PNS yang masih terikat KDO aktif, dan `422 Unprocessable Entity`).
4. **Keamanan Dasar**:
   - Proteksi endpoint API (menggunakan autentikasi session/Sanctum bawaan Laravel), proteksi CSRF, mass-assignment protection (`$fillable`), dan sanitasi input.
5. **Dokumentasi API**:
   - Sediakan dokumentasi REST API yang jelas (berupa file `API_DOCS.md` dan/atau halaman dokumentasi di dalam aplikasi) yang memuat daftar endpoint, method, parameter request, dan contoh response.

---

## 5. Spesifikasi Fungsional: Frontend (AdminLTE 3 + jQuery)

Antarmuka pengguna dibangun menggunakan Blade sebagai kerangka halaman dan **jQuery AJAX** untuk konsumsi data dari REST API:

1. **Kualitas UI/UX & Tata Letak**:
   - Gunakan komponen standar AdminLTE 3 (Sidebar navigasi, Navbar, Card, Small Box / Info Box, Badge warna sesuai kondisi kendaraan: Hijau = `Baik`, Kuning = `Rusak Ringan`, Merah = `Rusak Berat`).
   - Pastikan tampilan responsif, rapi, dan konsisten.
2. **Kelengkapan Tampilan**:
   - **Halaman Login**: Antarmuka autentikasi pengguna menggunakan tema AdminLTE 3.
   - **Dashboard Analitik**:
     - Ringkasan kartu statistik (Total KDO, Jumlah KDO Kondisi Baik, Rusak Ringan, Rusak Berat, Total PNS & PD).
     - Grafik visualisasi (Chart.js) perbandingan kondisi KDO dan distribusi KDO per Perangkat Daerah.
     - Daftar pengingat pajak/STNK yang akan jatuh tempo atau kendaraan yang membutuhkan perbaikan.
   - **Halaman Modul Perangkat Daerah (PD)**: Tabel daftar PD, modal/halaman detail (beserta daftar PNS & KDO di bawahnya), form tambah/ubah, dan konfirmasi hapus.
   - **Halaman Modul PNS**: Tabel daftar PNS (dengan filter Perangkat Daerah), tampilan detail pegawai & daftar KDO yang dipegang, form tambah/ubah, dan konfirmasi hapus.
   - **Halaman Modul KDO**: Tabel daftar KDO (dengan filter multi-kriteria: PD, Kondisi, Jenis Kendaraan), tampilan detail lengkap kendaraan + riwayat pemeliharaan/pemegang, form tambah/ubah, dan konfirmasi hapus.
   - **Fitur Cetak Laporan / Kartu Inventaris**: Halaman cetak ringkas (print-friendly) untuk rekapitulasi KDO atau Berita Acara / Kartu Kendaraan.
3. **Penggunaan Data Riil (Bukan Dummy)**:
   - Buat **Database Seeder** yang merepresentasikan data nyata dan masuk akal (Perangkat Daerah wajib: Dinas Pendidikan, Dinas Kesehatan, Dinas PUPR; data PNS dengan format NIP, jabatan, dan golongan riil; serta data KDO dengan merk, tipe, dan nomor polisi realistis di Indonesia).

---

## 6. Kewajiban Dokumentasi AI (`AGENTS.md` & `README.md`)

Karena pengembangan melibatkan bantuan AI, wajib menyertakan dua dokumen berikut di root proyek:

1. **`AGENTS.md`**:
   - Berisi instruksi, aturan arsitektur, batasan teknologi (Laravel 12, jQuery, MySQL, AdminLTE 3 lokal, tanpa Tailwind/React/Vue/Vite), dan pedoman kerja yang harus dipatuhi oleh AI Agent selama proses pembuatan dan pemeliharaan aplikasi.
2. **`README.md`**:
   - Berisi deskripsi aplikasi, daftar fitur, panduan instalasi & konfigurasi database, cara menjalankan migrasi dan seeder, ringkasan endpoint API, serta **informasi penggunaan AI** (contoh: *"Aplikasi ini dibangun menggunakan Antigravity IDE dengan model Gemini..."*).

---

## 7. Tahapan Implementasi (Action Plan untuk Pelaksana)

Kerjakan proyek secara bertahap mengikuti urutan milestone berikut:

### Tahap 1: Inisialisasi Proyek & Setup Asset Lokal
- Inisialisasi proyek Laravel 12 dan konfigurasi koneksi database MySQL pada `.env`.
- Siapkan asset lokal AdminLTE v3 beserta plugin pendukung (jQuery, Bootstrap 4, DataTables, Select2, SweetAlert2, Chart.js, FontAwesome) di dalam folder `public/adminlte/`.
- Buat master layout Blade (`layouts/app.blade.php` & `layouts/auth.blade.php`) tanpa menggunakan Vite maupun Tailwind CSS.

### Tahap 2: Perancangan Database, Model, & Seeder Data Riil
- Buat migration untuk tabel `perangkat_daerahs`, `pns`, `kdos`, serta tabel inovasi (`riwayat_pemeliharaans` / `riwayat_pemegangs`).
- Definisikan Eloquent Models beserta relasinya (`hasMany`, `belongsTo`).
- Buat Seeder dengan data riil (termasuk Dinas Pendidikan, Dinas Kesehatan, dan Dinas PUPR) untuk pengujian menyeluruh.

### Tahap 3: Pengembangan Backend REST API & Autentikasi
- Implementasikan sistem autentikasi dasar.
- Buat API Controller dan Form Request Validation untuk seluruh entitas (PD, PNS, KDO, Riwayat, dan Dashboard Summary).
- Terapkan format JSON response standar dan penanganan error (termasuk proteksi penghapusan data yang masih memiliki relasi aktif).

### Tahap 4: Pengembangan Frontend & Integrasi jQuery AJAX
- Bangun halaman Dashboard dengan grafik dan statistik dinamis dari endpoint API.
- Bangun antarmuka CRUD lengkap (List DataTables, Detail View, Form Modal/Page, Delete Confirmation) untuk Perangkat Daerah, PNS, dan KDO menggunakan jQuery AJAX.
- Tambahkan fitur filter data, pencarian, pencatatan riwayat servis/kondisi, serta fitur cetak laporan/kartu KDO.

### Tahap 5: Pengujian, Dokumentasi API, & Dokumentasi AI
- Lakukan pengujian fungsional (memastikan seluruh operasi CRUD via API & UI berjalan tanpa error).
- Susun dokumentasi REST API (`API_DOCS.md`).
- Buat file `AGENTS.md` dan `README.md` sesuai ketentuan penggunaan AI.
