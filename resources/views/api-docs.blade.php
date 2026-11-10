@extends('layouts.app')

@section('title', 'Dokumentasi REST API')
@section('page_title', 'Dokumentasi REST API SI-KDO BMD')

@section('breadcrumb')
<li class="breadcrumb-item active">Dokumentasi API</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-outline card-primary shadow-sm sticky-top" style="top: 20px;">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Daftar Modul API</h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush small font-weight-bold">
                    <a href="#section-overview" class="list-group-item list-group-item-action">
                        <i class="fas fa-info-circle mr-1 text-info"></i> 1. Standar Respon & Format
                    </a>
                    <a href="#section-auth" class="list-group-item list-group-item-action">
                        <i class="fas fa-key mr-1 text-warning"></i> 2. Autentikasi (Auth)
                    </a>
                    <a href="#section-dashboard" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt mr-1 text-primary"></i> 3. Dashboard Summary
                    </a>
                    <a href="#section-kdo" class="list-group-item list-group-item-action">
                        <i class="fas fa-car-side mr-1 text-primary"></i> 4. Kendaraan Dinas (KDO)
                    </a>
                    <a href="#section-pns" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-tie mr-1 text-success"></i> 5. Pegawai (PNS)
                    </a>
                    <a href="#section-pd" class="list-group-item list-group-item-action">
                        <i class="fas fa-landmark mr-1 text-warning"></i> 6. Perangkat Daerah (PD)
                    </a>
                    <a href="#section-pemeliharaan" class="list-group-item list-group-item-action">
                        <i class="fas fa-tools mr-1 text-danger"></i> 7. Riwayat Pemeliharaan
                    </a>
                    <a href="#section-pemegang" class="list-group-item list-group-item-action">
                        <i class="fas fa-history mr-1 text-secondary"></i> 8. Riwayat Pemegang BAST
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <!-- 1. Standar Respon -->
        <div class="card card-outline card-info shadow-sm mb-4" id="section-overview">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-info-circle text-info mr-1"></i> 1. Standarisasi Format JSON Respon
                </h3>
            </div>
            <div class="card-body">
                <p>Seluruh endpoint REST API SI-KDO BMD mengembalikan struktur JSON konsisten:</p>
                <div class="row">
                    <div class="col-md-6">
                        <span class="badge badge-success mb-2">Respon Berhasil (200 / 201)</span>
                        <pre class="bg-dark p-2 rounded text-white small"><code>{
  "success": true,
  "message": "Operasi berhasil dilakukan.",
  "data": { ... }
}</code></pre>
                    </div>
                    <div class="col-md-6">
                        <span class="badge badge-danger mb-2">Respon Gagal / Validasi (400 / 409 / 422)</span>
                        <pre class="bg-dark p-2 rounded text-white small"><code>{
  "success": false,
  "message": "Pesan deskripsi error.",
  "errors": {
    "field": ["Detail error"]
  }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Autentikasi -->
        <div class="card card-outline card-warning shadow-sm mb-4" id="section-auth">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-key text-warning mr-1"></i> 2. Endpoint Autentikasi
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 15%;">Method</th>
                            <th style="width: 35%;">Endpoint</th>
                            <th style="width: 50%;">Keterangan & Parameter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/auth/login</code></td>
                            <td>
                                <b>Login & Dapatkan Bearer Token.</b><br>
                                Body JSON: <code>{"email": "admin@kdo.go.id", "password": "password123"}</code>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/auth/logout</code></td>
                            <td>Keluar dari sistem dan mencabut access token.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/auth/me</code></td>
                            <td>Mengambil data profil pengguna yang sedang login.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 3. Dashboard -->
        <div class="card card-outline card-primary shadow-sm mb-4" id="section-dashboard">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-tachometer-alt text-primary mr-1"></i> 3. Endpoint Dashboard Summary
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge badge-primary mr-2 font-weight-bold">GET</span>
                    <code>/api/dashboard/summary</code>
                </div>
                <p class="text-muted small">
                    Mengembalikan seluruh ringkasan statistik kartu (Total KDO, Kondisi Baik, Rusak Ringan, Rusak Berat, Total PNS & PD), dataset visualisasi Chart.js, daftar pengingat pajak terdekat, dan KDO yang memerlukan perhatian servis.
                </p>
            </div>
        </div>

        <!-- 4. Kendaraan Dinas (KDO) -->
        <div class="card card-outline card-primary shadow-sm mb-4" id="section-kdo">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-car-side text-primary mr-1"></i> 4. Endpoint Kendaraan Dinas Operasional (KDO)
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 15%;">Method</th>
                            <th style="width: 30%;">Endpoint</th>
                            <th>Parameter / Body & Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/kdo</code></td>
                            <td>
                                <b>Daftar KDO (dengan Filter & Search).</b><br>
                                Query params: <code>search</code>, <code>perangkat_daerah_id</code>, <code>kondisi</code>, <code>status_penggunaan</code>, <code>kategori</code>, <code>per_page</code>.
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/kdo</code></td>
                            <td>
                                <b>Tambah KDO Baru.</b><br>
                                Body: <code>perangkat_daerah_id</code>, <code>pns_id</code>, <code>nomor_polisi</code>, <code>merk</code>, <code>tipe</code>, <code>kategori</code>, <code>tahun_produksi</code>, <code>warna</code>, <code>kondisi</code>, <code>status_penggunaan</code>, <code>foto</code> (file).
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/kdo/{id}</code></td>
                            <td>Detail lengkap KDO beserta relasi Perangkat Daerah, PNS, riwayat servis & riwayat BAST.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">PUT</span></td>
                            <td><code>/api/kdo/{id}</code></td>
                            <td>Perbarui data KDO. Jika terjadi pergantian <code>pns_id</code>, sistem otomatis memperbarui histori BAST.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">DELETE</span></td>
                            <td><code>/api/kdo/{id}</code></td>
                            <td>Hapus KDO beserta foto dan relasi riwayat terkait.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. Pegawai (PNS) -->
        <div class="card card-outline card-success shadow-sm mb-4" id="section-pns">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-user-tie text-success mr-1"></i> 5. Endpoint Pegawai Negeri Sipil (PNS)
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 15%;">Method</th>
                            <th style="width: 30%;">Endpoint</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/pns</code></td>
                            <td>Daftar seluruh PNS (Filter: <code>perangkat_daerah_id</code>, <code>status_pegawai</code>, <code>search</code>).</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/pns</code></td>
                            <td>Tambah PNS baru (NIP unik 18 digit, validasi instansi).</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/pns/{id}</code></td>
                            <td>Detail PNS beserta daftar kendaraan yang sedang/pernah dipegang.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">PUT</span></td>
                            <td><code>/api/pns/{id}</code></td>
                            <td>Perbarui informasi data pegawai.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">DELETE</span></td>
                            <td><code>/api/pns/{id}</code></td>
                            <td>Hapus data PNS. Dilindungi: mengembalikan <b>409 Conflict</b> jika PNS masih memegang KDO aktif.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 6. Perangkat Daerah -->
        <div class="card card-outline card-warning shadow-sm mb-4" id="section-pd">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-landmark text-warning mr-1"></i> 6. Endpoint Perangkat Daerah (PD)
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 15%;">Method</th>
                            <th style="width: 30%;">Endpoint</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/perangkat-daerah</code></td>
                            <td>Daftar seluruh Perangkat Daerah beserta jumlah pegawai dan kendaraan.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/perangkat-daerah</code></td>
                            <td>Tambah Perangkat Daerah baru (Kode PD unik).</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/perangkat-daerah/{id}</code></td>
                            <td>Detail Perangkat Daerah beserta daftar KDO dan daftar PNS di bawahnya.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">PUT</span></td>
                            <td><code>/api/perangkat-daerah/{id}</code></td>
                            <td>Perbarui data instansi / kepala dinas.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">DELETE</span></td>
                            <td><code>/api/perangkat-daerah/{id}</code></td>
                            <td>Hapus instansi. Dilindungi: mengembalikan <b>409 Conflict</b> jika masih memiliki PNS atau KDO.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 7. Riwayat Pemeliharaan & 8. BAST -->
        <div class="card card-outline card-danger shadow-sm mb-4" id="section-pemeliharaan">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-tools text-danger mr-1"></i> 7. Endpoint Riwayat Pemeliharaan & 8. BAST
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 15%;">Method</th>
                            <th style="width: 35%;">Endpoint</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/riwayat-pemeliharaan</code></td>
                            <td>Daftar histori servis (Filter: <code>kdo_id</code>).</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/riwayat-pemeliharaan</code></td>
                            <td>Catat servis baru. Otomatis mensinkronisasi kondisi KDO sesuai <code>kondisi_setelah</code>.</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-primary">GET</span></td>
                            <td><code>/api/riwayat-pemegang</code></td>
                            <td>Daftar histori BAST penugasan kendaraan (Filter: <code>kdo_id</code>, <code>pns_id</code>).</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">POST</span></td>
                            <td><code>/api/riwayat-pemegang</code></td>
                            <td>Catat berita acara serah terima (BAST) baru.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
