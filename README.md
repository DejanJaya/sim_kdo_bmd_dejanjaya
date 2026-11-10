# SI-KDO BMD: Sistem Informasi Pengelolaan Kendaraan Dinas Operasional

> **Informasi Penggunaan AI:**  
> Aplikasi ini dirancang dan dibangun secara terstruktur menggunakan **Antigravity IDE** dengan model **Gemini 3.8**. Seluruh instruksi arsitektur, batasan teknis, dan alur kerja AI didokumentasikan di dalam file [`AGENTS.md`](./AGENTS.md).

---

## 1. Tentang Aplikasi

**SI-KDO BMD** adalah aplikasi web komprehensif yang dirancang untuk mengelola data **Kendaraan Dinas Operasional (KDO)** milik Perangkat Daerah sebagai bagian integral dari pengelolaan **Barang Milik Daerah (BMD)** pemerintah daerah.

Aplikasi ini mencakup:
1. **Pendataan Inventaris KDO**: Nomor Polisi plat merah, Kode Barang BMD (NUP), merk, tipe, tahun, warna, nomor rangka, nomor mesin, BPKB, dan masa berlaku pajak/STNK.
2. **Pemantauan Kondisi Fisik Real-Time**: Status kondisi fisik terkini (`Baik`, `Rusak Ringan`, `Rusak Berat`) untuk kesiapan operasional, penganggaran servis, maupun usulan lelang penghapusan BMD.
3. **Akuntabilitas Penanggung Jawab (PNS)**: Pegawai Negeri Sipil (PNS) penanggung jawab dengan standar NIP 18 digit resmi BKN, jabatan, dan golongan ruang.
4. **Perangkat Daerah (PD / SKPD)**: Pengelolaan unit kerja OPD (termasuk Dinas Pendidikan, Dinas Kesehatan, Dinas PUPR, BPKAD, dan Dishub).
5. **Riwayat Pemeliharaan & BAST (Inovasi)**: Pencatatan servis rutin, rincian biaya, bengkel pelaksana, sinkronisasi otomatis kondisi kendaraan, serta riwayat Berita Acara Serah Terima (BAST) pemegang.
6. **Cetak Dokumen Resmi**: Format cetak siap pakai (*print-friendly*) untuk **Kartu Identitas KDO** dan **Laporan Rekapitulasi Inventaris BMD**.

---

## 2. Tech Stack & Kepatuhan Batasan Dependency

Sesuai instruksi dan batasan teknis wajib proyek:

- **Backend Framework**: Laravel 12 (PHP 8.3+)
- **Database**: MySQL / MariaDB
- **Frontend Template**: AdminLTE versi 3 (**100% Asset Lokal** di `public/adminlte/`)
- **Frontend Scripting**: Vanilla JavaScript & jQuery AJAX
- **Library Pendukung Lokal**: Bootstrap 4, DataTables, Select2, SweetAlert2, Chart.js, FontAwesome

### Kepatuhan Batasan Arsitektur:
-  **Tanpa Tailwind CSS**: Antarmuka murni menggunakan Bootstrap 4 bawaan AdminLTE v3.
-  **Tanpa React atau Vue**: Interaksi dinamis ditangani langsung oleh jQuery AJAX.
-  **Tanpa Vite untuk AdminLTE**: Asset dipanggil secara lokal melalui helper `asset('adminlte/...')`.
-  **Asset Lokal Mandiri**: Tidak bergantung pada CDN luar untuk aset antarmuka.
-  **Tanpa Penambahan Dependency Liar**: Bersih dari paket tambahan yang tidak disetujui.

---

## 3. Berkas Pendukung (Database Dump & Postman Collection)

Untuk memudahkan verifikasi dan pengujian oleh penilai/evaluator:

1. **Dump Database MySQL (Data Riil)**:
   - File: [`database/dump/app_kdo_dump.sql`](./database/dump/app_kdo_dump.sql)
   - Berisi skema tabel lengkap beserta data awal realistis (OPD nyata, PNS dengan NIP BKN, dan kendaraan dinas operasional plat merah).
2. **Koleksi REST API Postman**:
   - File: [`postman/SI-KDO_BMD.postman_collection.json`](./postman/SI-KDO_BMD.postman_collection.json)
   - Siap langsung di-*import* ke Postman dengan koleksi endpoint lengkap (Auth, Dashboard, KDO CRUD, PNS CRUD, PD CRUD, Riwayat Pemeliharaan CRUD, BAST, dan Laporan Rekapitulasi BMD).

---

## 4. Tangkapan Layar Aplikasi & Pengujian (Track Fullstack)

Berikut adalah dokumentasi visual lengkap hasil implementasi antarmuka web (List, Form Create, Form Edit, Detail, & Cetak) dan pengujian REST API di Postman (List, Create, Detail, Update, Delete, Servis, & Laporan):

### A. Antarmuka Web (Frontend - AdminLTE 3 + jQuery)

#### 1. Halaman Masuk Sistem (Login AdminLTE 3)
Antarmuka login aman dengan panduan kredensial default bawaan sistem.
![Login Page](screenshot_fullstack/ui/01_login_page.png)

#### 2. Dashboard Eksekutif & Visualisasi Grafik (Chart.js)
Ringkasan kartu statistik kondisi kendaraan, grafik donat proporsi kondisi KDO, bar chart distribusi unit per SKPD, dan tabel peringatan jatuh tempo pajak terdekat.
![Dashboard Overview](screenshot_fullstack/ui/02_dashboard_overview.png)

#### 3. Modul KDO: Tabel Daftar Inventaris Kendaraan (List View)
Tabel inventaris DataTables dengan multi-filter (SKPD, Kondisi, Status, Kategori), pencarian cepat, dan badge status visual.
![KDO List Table](screenshot_fullstack/ui/03_kdo_list_table.png)

#### 4. Modul KDO: Modal Form Tambah KDO Baru (Create View)
Form modal penambahan kendaraan dinas baru lengkap dengan spesifikasi teknis, nomor rangka, nomor mesin, BPKB, tanggal pajak, dan unggah foto fisik.
![KDO Form Create](screenshot_fullstack/ui/04_kdo_form_create.png)

#### 5. Modul KDO: Modal Form Ubah KDO (Edit View)
Form modal pengubahan data KDO. Jika terjadi pergantian pegawai penanggung jawab, sistem otomatis mencatat riwayat BAST penugasan.
![KDO Form Edit](screenshot_fullstack/ui/05_kdo_form_edit.png)

#### 6. Modul KDO: Modal Detail Lengkap & Riwayat Servis / BAST (Detail View)
Tampilan rincian spesifikasi teknis, legalitas kendaraan, serta tab riwayat servis dan tab penugasan BAST pemegang kendaraan.
![KDO Detail Modal](screenshot_fullstack/ui/06_kdo_detail_modal.png)

#### 7. Modul PNS: Tabel Daftar Pegawai Penanggung Jawab (List View)
Daftar pegawai penanggung jawab KDO dengan NIP 18 digit standar BKN, jabatan, golongan ruang, dan indikator unit kendaraan yang dipegang.
![PNS List Table](screenshot_fullstack/ui/07_pns_list_table.png)

#### 8. Modul PNS: Modal Form Tambah Pegawai (Create View)
Form modal penambahan data PNS baru dengan validasi instansi dan NIP unik 18 digit.
![PNS Form Create](screenshot_fullstack/ui/08_pns_form_create.png)

#### 9. Modul PNS: Modal Form Ubah Pegawai (Edit View)
Form modal pembaruan data pegawai, jabatan, kontak, serta pangkat/golongan ruang.
![PNS Form Edit](screenshot_fullstack/ui/09_pns_form_edit.png)

#### 10. Modul Perangkat Daerah (PD): Tabel Daftar Instansi (List View)
Daftar instansi pemerintah daerah (Dinas Pendidikan, Dinkes, Dinas PUPR, BPKAD, Dishub) dengan data pimpinan dan jumlah aset kendaraan.
![Perangkat Daerah List Table](screenshot_fullstack/ui/10_perangkat_daerah_list_table.png)

#### 11. Modul Perangkat Daerah (PD): Modal Form Tambah Instansi (Create View)
Form modal penambahan instansi/OPD baru dengan klasifikasi kode PD standar daerah.
![Perangkat Daerah Form Create](screenshot_fullstack/ui/11_perangkat_daerah_form_create.png)

#### 12. Modul Perangkat Daerah (PD): Modal Form Ubah Instansi (Edit View)
Form modal pembaruan nama instansi, singkatan, pimpinan, dan alamat kantor dinas.
![Perangkat Daerah Form Edit](screenshot_fullstack/ui/12_perangkat_daerah_form_edit.png)

#### 13. Modul Riwayat Pemeliharaan: Tabel Buku Catatan Servis (List View)
Pencatatan riwayat servis berkala, biaya pemeliharaan, bengkel pelaksana, dan pembaruan kondisi fisik kendaraan secara otomatis.
![Riwayat Pemeliharaan Table](screenshot_fullstack/ui/13_riwayat_pemeliharaan_table.png)

#### 14. Modul Riwayat Pemeliharaan: Modal Form Catat Servis Baru (Create View)
Form modal pencatatan pemeliharaan fisik KDO dengan opsi pembaruan otomatis kondisi kendaraan pasca servis.
![Pemeliharaan Form Create](screenshot_fullstack/ui/14_pemeliharaan_form_create.png)

#### 15. Cetak Kartu Identitas Kendaraan Dinas (KDO)
Format cetak resmi individual kartu identitas inventaris KDO dilengkapi kop surat dinas, data teknis, ringkasan servis, dan kolom tanda tangan pimpinan/pengurus barang.
![Cetak Kartu KDO](screenshot_fullstack/ui/15_cetak_kartu_kdo.png)

#### 16. Cetak Laporan Rekapitulasi Inventaris BMD
Rekapitulasi cetak resmi untuk lampiran Laporan Keuangan Pemerintah Daerah (LKPD) Bagian Aset Tetap BMD.
![Cetak Laporan BMD](screenshot_fullstack/ui/16_cetak_laporan_bmd.png)

---

### B. Bukti Pengujian REST API di Postman (Backend CRUD Lengkap)

#### 1. POST Autentikasi Login (`/api/auth/login`)
Pengujian login berhasil menghasilkan token Sanctum Bearer dan data profil user.
![Postman Login](screenshot_fullstack/API-postman/01_postman_auth_login.png)

#### 2. GET Ringkasan Dashboard (`/api/dashboard/summary`)
Pengujian pengambilan data agregasi kartu, dataset grafik Chart.js, dan pengingat pajak dalam format JSON terstandar.
![Postman Dashboard Summary](screenshot_fullstack/API-postman/02_postman_dashboard_summary.png)

#### 3. GET Daftar KDO dengan Filter [READ - LIST] (`/api/kdo?kondisi=Baik`)
Pengujian pengambilan daftar data KDO dengan filter kondisi baik secara asinkronus beserta relasi Perangkat Daerah dan PNS.
![Postman KDO List](screenshot_fullstack/API-postman/03_postman_kdo_list.png)

#### 4. POST Tambah KDO Baru [CREATE] (`/api/kdo`)
Pengujian penambahan kendaraan dinas baru beserta pembuatan riwayat awal BAST penugasan secara otomatis (Status 201 Created).
![Postman KDO Create](screenshot_fullstack/API-postman/04_postman_kdo_create.png)

#### 5. GET Detail KDO by ID [READ - DETAIL] (`/api/kdo/1`)
Pengujian pengambilan detail spesifikasi teknis, nomor rangka, mesin, BPKB, serta relasi riwayat servis dan penugasan BAST pemegang.
![Postman KDO Detail](screenshot_fullstack/API-postman/05_postman_kdo_detail.png)

#### 6. PUT Ubah Data KDO [UPDATE] (`/api/kdo/1`)
Pengujian pembaruan data KDO dan pengalihan pemegang kendaraan yang secara otomatis mencatat riwayat BAST baru.
![Postman KDO Update](screenshot_fullstack/API-postman/06_postman_kdo_update.png)

#### 7. DELETE Hapus KDO [DELETE] (`/api/kdo/14`)
Pengujian penghapusan kendaraan dinas beserta berkas foto fisik terkait (Status 200 OK).
![Postman KDO Delete](screenshot_fullstack/API-postman/07_postman_kdo_delete.png)

#### 8. GET Daftar Pegawai PNS (`/api/pns`)
Pengujian pengambilan data pegawai penanggung jawab kendaraan dinas beserta jumlah kendaraan aktif.
![Postman PNS List](screenshot_fullstack/API-postman/08_postman_pns_list.png)

#### 9. DELETE Uji Integritas Referensial [DELETE PROTECTION] (`409 Conflict`)
Pengujian proteksi sistem saat mencoba menghapus Perangkat Daerah yang masih memiliki pegawai atau kendaraan dinas aktif.
![Postman 409 Conflict](screenshot_fullstack/API-postman/09_postman_delete_pd_conflict_409.png)

#### 10. POST Catat Riwayat Servis Baru [CREATE SERVIS] (`/api/riwayat-pemeliharaan`)
Pengujian pencatatan servis di bengkel rekanan dengan sinkronisasi otomatis kondisi KDO (Status 201 Created).
![Postman Servis Create](screenshot_fullstack/API-postman/10_postman_riwayat_servis_create.png)

#### 11. GET Daftar Riwayat Pemeliharaan [LIST SERVIS] (`/api/riwayat-pemeliharaan`)
Pengujian pengambilan daftar histori servis dan pemeliharaan KDO beserta rincian biaya dan bengkel.
![Postman Servis List](screenshot_fullstack/API-postman/11_postman_riwayat_servis_list.png)

#### 12. PUT Ubah Catatan Pemeliharaan [UPDATE SERVIS] (`/api/riwayat-pemeliharaan/1`)
Pengujian pembaruan rincian biaya servis dan hasil kondisi kendaraan pasca perbaikan.
![Postman Servis Update](screenshot_fullstack/API-postman/12_postman_riwayat_servis_update.png)

#### 13. GET Rekapitulasi Laporan Inventaris BMD [LAPORAN API] (`/api/laporan/rekapitulasi`)
Pengujian endpoint REST API laporan rekapitulasi inventaris KDO BMD lengkap dengan metadata unit per kondisi dan filter terapan.
![Postman Laporan API](screenshot_fullstack/API-postman/13_postman_laporan_rekapitulasi_bmd.png)

---

## 5. Akun Pengguna Bawaan (Default Credentials)

| Peran (Role) | Email | Kata Sandi | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Administrator BMD** | `admin@kdo.go.id` | `password123` | Akses penuh master data, operasional, & cetak |
| **Operator Aset** | `operator@kdo.go.id` | `password123` | Pengelola pendataan operasional |

---

## 6. Panduan Instalasi & Menjalankan Proyek

### Prasyarat:
- PHP >= 8.3 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `gd`)
- Composer
- Server MySQL / MariaDB

### Langkah Cepat:
1. **Konfigurasi Database di `.env`**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=app_kdo
   DB_USERNAME=root
   DB_PASSWORD=root
   ```

2. **Migrasi Database & Seeder Data Riil**:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *(Atau impor langsung file dump SQL yang telah disediakan di `database/dump/app_kdo_dump.sql`)*

3. **Hubungkan Storage Symlink**:
   ```bash
   php artisan storage:link
   ```

4. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses melalui browser: **`http://localhost:8000`**

5. **Menjalankan Pengujian Otomatis (PHPUnit)**:
   ```bash
   php artisan test
   ```
