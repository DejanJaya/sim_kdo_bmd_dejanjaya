# Instruksi AI & Architecture Guidelines (AGENTS.md)

Dokumen ini memuat panduan, batasan arsitektur, dan instruksi teknis yang wajib dipatuhi oleh seluruh AI Agent (atau pengembang) yang bekerja pada proyek **Aplikasi Pengelolaan Kendaraan Dinas Operasional (SI-KDO BMD)**.

---

## 1. Spesifikasi Teknologi & Batasan Ketat (Mandatory Constraints)

1. **Framework & Bahasa**:
   - Backend wajib menggunakan **Laravel 12 (PHP 8.3+)**.
   - Database wajib menggunakan **MySQL / MariaDB**.
   - Frontend wajib menggunakan **AdminLTE versi 3**.
   - Bahasa antarmuka interaktif: **Vanilla JavaScript & jQuery** (menggunakan AJAX untuk berinteraksi dengan REST API).
2. **Larangan Dependency**:
   - **DILARANG** menginstal atau menggunakan Tailwind CSS.
   - **DILARANG** menggunakan framework SPA reaktif seperti React, Vue, atau Angular.
   - **DILARANG** menggunakan Vite untuk mengintegrasikan AdminLTE. Jangan memanggil `@vite` pada file Blade AdminLTE.
   - **WAJIB Menggunakan Asset Lokal**: Semua asset AdminLTE v3 (CSS, JS, plugin FontAwesome, DataTables, Select2, SweetAlert2, Chart.js) disimpan di folder `public/adminlte/` dan dipanggil menggunakan helper `asset('adminlte/...')`.
   - **DILARANG** menambah dependensi NPM atau Composer baru tanpa persetujuan eksplisit.
3. **Data Riil**:
   - Data pengujian dan seeder **wajib realistis (bukan dummy asal-asalan)**, mencakup nama instansi pemerintah daerah nyata (Dinas Pendidikan, Dinas Kesehatan, Dinas PUPR, dll.), format NIP 18 digit standar BKN, jabatan PNS, dan nomor polisi plat merah di Indonesia.

---

## 2. Struktur Arsitektur & Pola Desain

### A. Pola Backend (REST API First)
- Seluruh logika transaksi dan manipulasi data dioperasikan melalui endpoint REST API yang bersih di `routes/api.php`.
- Format JSON respon harus selalu seragam menggunakan trait `App\Traits\ApiResponse`:
  ```json
  // Berhasil
  {
    "success": true,
    "message": "Pesan sukses",
    "data": { ... }
  }

  // Gagal / Error
  {
    "success": false,
    "message": "Pesan kesalahan",
    "errors": { ... }
  }
  ```
- **Integritas Referensial**:
  - Penghapusan instansi (Perangkat Daerah) yang masih memiliki PNS atau KDO wajib dicegah dengan respon `409 Conflict`.
  - Penghapusan PNS yang masih tercatat sebagai pemegang KDO aktif wajib dicegah dengan respon `409 Conflict`.
  - Jika terjadi pergantian `pns_id` pada KDO, sistem wajib mencatat riwayat BAST penugasan secara otomatis.

### B. Pola Frontend (Blade + jQuery AJAX)
- Blade digunakan sebagai kerangka layout server-side (`layouts/app.blade.php` dan `layouts/auth.blade.php`).
- Seluruh tabel list, modal CRUD, dan visualisasi chart memanfaatkan **jQuery AJAX** yang terhubung ke endpoint `/api/...`.
- `X-CSRF-TOKEN` dan header `Accept: application/json` dikonfigurasikan secara global di `layouts/app.blade.php`.

---

## 3. Entitas & Relasi Data

1. **PerangkatDaerah (`perangkat_daerahs`)**:
   - Memiliki relasi `hasMany` ke `Pns` dan `Kdo`.
2. **Pns (`pns`)**:
   - Memiliki relasi `belongsTo` ke `PerangkatDaerah`.
   - Memiliki relasi `hasMany` ke `Kdo` (sebagai pemegang aktif) dan `RiwayatPemegang` (BAST).
3. **Kdo (`kdos`)**:
   - Memiliki relasi `belongsTo` ke `PerangkatDaerah` dan `Pns`.
   - Memiliki relasi `hasMany` ke `RiwayatPemeliharaan` dan `RiwayatPemegang`.
4. **RiwayatPemeliharaan (`riwayat_pemeliharaans`)**:
   - Memiliki relasi `belongsTo` ke `Kdo`.
   - Mencatat servis, bengkel, biaya, dan perubahan kondisi fisik kendaraan (`Baik`, `Rusak Ringan`, `Rusak Berat`).
5. **RiwayatPemegang (`riwayat_pemegangs`)**:
   - Memiliki relasi `belongsTo` ke `Kdo` dan `Pns`.
   - Mencatat nomor BAST, tanggal mulai/selesai serah terima pemegang.

---

## 4. Pedoman untuk AI Agent Penerus

- Jika menambahkan fitur baru, pastikan endpoint REST API dibuat terlebih dahulu lengkap dengan validasi form dan error handling sebelum membuat antarmuka Blade.
- Pertahankan struktur asset lokal di `public/adminlte/`.
- Jangan mengubah port database atau menghapus seeder data riil.
