@extends('layouts.app')

@section('title', 'Kendaraan Dinas (KDO)')
@section('page_title', 'Kelola Kendaraan Dinas Operasional (KDO)')

@section('breadcrumb')
<li class="breadcrumb-item active">Kendaraan Dinas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filter Card -->
        <div class="card card-outline card-primary shadow-sm mb-3">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-landmark mr-1"></i> Perangkat Daerah:</label>
                        <select id="filter-pd" class="form-control form-control-sm select2">
                            <option value="">-- Seluruh Perangkat Daerah --</option>
                            @foreach($perangkatDaerahs as $pd)
                                <option value="{{ $pd->id }}">{{ $pd->nama_pd }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-heartbeat mr-1"></i> Kondisi Fisik:</label>
                        <select id="filter-kondisi" class="form-control form-control-sm">
                            <option value="">-- Seluruh Kondisi --</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ request('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-toggle-on mr-1"></i> Status Penggunaan:</label>
                        <select id="filter-status-penggunaan" class="form-control form-control-sm">
                            <option value="">-- Seluruh Status --</option>
                            <option value="Digunakan">Digunakan</option>
                            <option value="Tersedia/Pool">Tersedia (Pool)</option>
                            <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-car mr-1"></i> Kategori:</label>
                        <select id="filter-kategori" class="form-control form-control-sm">
                            <option value="">-- Seluruh Kategori --</option>
                            <option value="Roda 4">Roda 4</option>
                            <option value="Roda 2">Roda 2</option>
                            <option value="Roda 6">Roda 6</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-3 text-md-right mt-3 mt-md-0">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-1" onclick="resetFilters()">
                            <i class="fas fa-undo mr-1"></i> Reset
                        </button>
                        <button type="button" class="btn btn-sm btn-primary font-weight-bold shadow-sm" onclick="openCreateModal()">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah KDO
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card Data -->
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-car-side text-primary mr-1"></i>
                    Daftar Inventaris Kendaraan Dinas Operasional (BMD)
                </h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-info">
                        <i class="fas fa-print mr-1"></i> Cetak Laporan BMD
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="table-kdo" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 4%;">No</th>
                                <th style="width: 12%;">No. Polisi</th>
                                <th style="width: 20%;">Merk & Tipe</th>
                                <th style="width: 10%;">Tahun / Kat.</th>
                                <th style="width: 18%;">Perangkat Daerah</th>
                                <th style="width: 14%;">Penanggung Jawab</th>
                                <th style="width: 10%;" class="text-center">Kondisi</th>
                                <th style="width: 12%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Tambah / Edit KDO -->
<div class="modal fade" id="modal-kdo-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-kdo-title">
                    <i class="fas fa-car-side mr-1"></i> Form Kendaraan Dinas Operasional
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-kdo" enctype="multipart/form-data">
                <input type="hidden" id="kdo-id" name="id">
                <div class="modal-body">
                    <div id="kdo-alert-error" class="alert alert-danger d-none"></div>

                    <div class="row">
                        <!-- Kolom Kiri: Instansi & Identitas Kendaraan -->
                        <div class="col-md-6 border-right">
                            <h6 class="font-weight-bold text-primary mb-3">
                                <i class="fas fa-info-circle mr-1"></i> Kepemilikan & Identitas Kendaraan
                            </h6>

                            <div class="form-group">
                                <label for="perangkat_daerah_id">Perangkat Daerah Pengguna <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="perangkat_daerah_id" name="perangkat_daerah_id" required style="width: 100%;">
                                    <option value="">-- Pilih Perangkat Daerah --</option>
                                    @foreach($perangkatDaerahs as $pd)
                                        <option value="{{ $pd->id }}">{{ $pd->nama_pd }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pns_id">Pegawai Penanggung Jawab (Pemegang Saat Ini)</label>
                                <select class="form-control select2" id="pns_id" name="pns_id" style="width: 100%;">
                                    <option value="">-- Kosongkan Jika Kendaraan Pool / Belum Ditugaskan --</option>
                                    @foreach($pnsList as $pns)
                                        <option value="{{ $pns->id }}">
                                            {{ $pns->nama }} ({{ $pns->jabatan }} - {{ $pns->perangkatDaerah->singkatan ?? $pns->perangkatDaerah->nama_pd }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Jika diisi, histori BAST pemegang akan otomatis tercatat.</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nomor_polisi">Nomor Polisi (Plat Merah) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control font-weight-bold" id="nomor_polisi" name="nomor_polisi" 
                                               placeholder="Contoh: B 1024 PQD" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kode_barang">Kode Barang / NUP (BMD)</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" 
                                               placeholder="Contoh: 02.03.01.01.001">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="merk">Merk Kendaraan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="merk" name="merk" 
                                               placeholder="Contoh: Toyota, Honda, Isuzu" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipe">Tipe / Model <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tipe" name="tipe" 
                                               placeholder="Contoh: Innova 2.0 V A/T" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="kategori">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-control" id="kategori" name="kategori" required>
                                            <option value="Roda 4">Roda 4</option>
                                            <option value="Roda 2">Roda 2</option>
                                            <option value="Roda 6">Roda 6</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tahun_produksi">Tahun Produksi <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="tahun_produksi" name="tahun_produksi" 
                                               min="1990" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="warna">Warna Kendaraan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="warna" name="warna" 
                                               placeholder="Contoh: Hitam Metalik" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan: Legalitas, Kondisi, Status & Foto -->
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-primary mb-3">
                                <i class="fas fa-file-alt mr-1"></i> Data Legalitas, Kondisi & Status
                            </h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kondisi">Kondisi Fisik Kendaraan <span class="text-danger">*</span></label>
                                        <select class="form-control" id="kondisi" name="kondisi" required>
                                            <option value="Baik">Baik (Siap Operasional)</option>
                                            <option value="Rusak Ringan">Rusak Ringan (Perlu Servis)</option>
                                            <option value="Rusak Berat">Rusak Berat (Usul Hapus/Lelang)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status_penggunaan">Status Penggunaan <span class="text-danger">*</span></label>
                                        <select class="form-control" id="status_penggunaan" name="status_penggunaan" required>
                                            <option value="Digunakan">Digunakan</option>
                                            <option value="Tersedia/Pool">Tersedia (Pool)</option>
                                            <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor_rangka">Nomor Rangka</label>
                                        <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" placeholder="Nomor Rangka">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor_mesin">Nomor Mesin</label>
                                        <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" placeholder="Nomor Mesin">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomor_bpkb">Nomor BPKB</label>
                                        <input type="text" class="form-control" id="nomor_bpkb" name="nomor_bpkb" placeholder="Nomor BPKB">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pajak">Jatuh Tempo Pajak / STNK</label>
                                        <input type="date" class="form-control" id="tanggal_pajak" name="tanggal_pajak">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto">Foto Kendaraan (Opsional)</label>
                                        <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                                        <small class="text-muted">JPG, PNG, WebP maks 3MB</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">Keterangan Tambahan / Catatan Fisik</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="2" 
                                          placeholder="Catatan kondisi body, kelengkapan surat, perlengkapan, dll."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-kdo">
                        <i class="fas fa-save mr-1"></i> Simpan Data KDO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Lengkap KDO -->
<div class="modal fade" id="modal-kdo-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="detail-kdo-title">Detail Kendaraan Dinas Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Header Box: Plat Nomor & Status Ringkas -->
                <div class="callout callout-info py-2 px-3 mb-3 d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <span class="h4 font-weight-bold text-primary mr-2" id="detail-kdo-nopol">-</span>
                        <span id="detail-kdo-kondisi-badge"></span>
                        <span id="detail-kdo-status-badge" class="ml-1"></span>
                    </div>
                    <div>
                        <a href="#" id="btn-print-kdo-card" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-id-card mr-1"></i> Cetak Kartu Kendaraan
                        </a>
                    </div>
                </div>

                <!-- Tabs: Spesifikasi, Riwayat Servis, Histori Pemegang -->
                <ul class="nav nav-tabs font-weight-bold" id="kdo-detail-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-spesifikasi-link" data-toggle="tab" href="#tab-spesifikasi" role="tab">
                            <i class="fas fa-info-circle mr-1 text-primary"></i> Spesifikasi & Kepemilikan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-servis-link" data-toggle="tab" href="#tab-servis" role="tab">
                            <i class="fas fa-tools mr-1 text-danger"></i> Riwayat Pemeliharaan & Servis (<span id="count-servis">0</span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-bast-link" data-toggle="tab" href="#tab-bast" role="tab">
                            <i class="fas fa-history mr-1 text-success"></i> Histori Pemegang / BAST (<span id="count-bast">0</span>)
                        </a>
                    </li>
                </ul>

                <div class="tab-content pt-3" id="kdo-detail-tabs-content">
                    <!-- Tab Spesifikasi -->
                    <div class="tab-pane fade show active" id="tab-spesifikasi" role="tabpanel">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <th style="width: 35%;">Perangkat Daerah:</th>
                                        <td id="detail-kdo-pd" class="font-weight-bold">-</td>
                                    </tr>
                                    <tr>
                                        <th>Penanggung Jawab (PNS):</th>
                                        <td id="detail-kdo-pns">-</td>
                                    </tr>
                                    <tr>
                                        <th>Merk & Model / Tipe:</th>
                                        <td id="detail-kdo-merk-tipe" class="font-weight-bold">-</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori & Tahun Produksi:</th>
                                        <td id="detail-kdo-kategori-tahun">-</td>
                                    </tr>
                                    <tr>
                                        <th>Warna Kendaraan:</th>
                                        <td id="detail-kdo-warna">-</td>
                                    </tr>
                                    <tr>
                                        <th>Kode Barang BMD (NUP):</th>
                                        <td id="detail-kdo-kode-barang"><code>-</code></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Rangka:</th>
                                        <td id="detail-kdo-norangka"><code>-</code></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Mesin:</th>
                                        <td id="detail-kdo-nomesin"><code>-</code></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor BPKB:</th>
                                        <td id="detail-kdo-nobpkb"><code>-</code></td>
                                    </tr>
                                    <tr>
                                        <th>Jatuh Tempo Pajak / STNK:</th>
                                        <td id="detail-kdo-pajak">-</td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan / Catatan:</th>
                                        <td id="detail-kdo-keterangan" class="text-muted">-</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5 text-center">
                                <label class="font-weight-bold text-muted d-block text-left mb-2">Foto Fisik Kendaraan:</label>
                                <div id="detail-kdo-foto-container" class="border rounded p-2 bg-light">
                                    <img id="detail-kdo-foto" src="" alt="Foto KDO" class="img-fluid rounded shadow-sm" style="max-height: 250px; display: none;">
                                    <div id="detail-kdo-no-foto" class="py-5 text-muted">
                                        <i class="fas fa-car fa-4x text-muted mb-2"></i>
                                        <p class="mb-0">Tidak ada foto kendaraan terlampir.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Riwayat Pemeliharaan -->
                    <div class="tab-pane fade" id="tab-servis" role="tabpanel">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Catatan riwayat servis berkala, perbaikan mesin, dan perubahan status kondisi.</span>
                            <a href="{{ route('pemeliharaan.index') }}" class="btn btn-xs btn-outline-danger">
                                <i class="fas fa-plus-circle mr-1"></i> Input Servis Baru
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover" id="detail-kdo-servis-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Tanggal Servis</th>
                                        <th>Jenis Pemeliharaan</th>
                                        <th>Bengkel Pelaksana</th>
                                        <th>Biaya</th>
                                        <th>Kondisi Sebelum</th>
                                        <th>Kondisi Setelah</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Riwayat Pemegang / BAST -->
                    <div class="tab-pane fade" id="tab-bast" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover" id="detail-kdo-bast-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No. BAST</th>
                                        <th>Nama Pegawai (PNS)</th>
                                        <th>Jabatan Pegawai</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status BAST</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let tableKdo = null;

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        initDataTable();

        $('#filter-pd, #filter-kondisi, #filter-status-penggunaan, #filter-kategori').on('change', function() {
            tableKdo.ajax.reload();
        });

        $('#form-kdo').on('submit', function(e) {
            e.preventDefault();
            saveKdo();
        });
    });

    function resetFilters() {
        $('#filter-pd').val('').trigger('change');
        $('#filter-kondisi').val('');
        $('#filter-status-penggunaan').val('');
        $('#filter-kategori').val('');
        tableKdo.ajax.reload();
    }

    function initDataTable() {
        tableKdo = $('#table-kdo').DataTable({
            processing: true,
            responsive: true,
            ajax: {
                url: '/api/kdo',
                type: 'GET',
                data: function(d) {
                    d.perangkat_daerah_id = $('#filter-pd').val();
                    d.kondisi = $('#filter-kondisi').val();
                    d.status_penggunaan = $('#filter-status-penggunaan').val();
                    d.kategori = $('#filter-kategori').val();
                },
                dataSrc: function(json) {
                    return json.data.data || json.data || [];
                }
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nomor_polisi',
                    render: function(data, type, row) {
                        return `
                            <div class="font-weight-bold text-dark font-monospace">${data}</div>
                            <small class="text-muted">${row.kode_barang || '-'}</small>
                        `;
                    }
                },
                {
                    data: 'merk',
                    render: function(data, type, row) {
                        return `
                            <div class="font-weight-bold text-primary">${data} ${row.tipe}</div>
                            <small class="text-muted"><i class="fas fa-palette mr-1"></i> ${row.warna}</small>
                        `;
                    }
                },
                {
                    data: 'tahun_produksi',
                    render: function(data, type, row) {
                        return `
                            <div>${data}</div>
                            <span class="badge badge-light border">${row.kategori}</span>
                        `;
                    }
                },
                {
                    data: 'perangkat_daerah',
                    render: function(data) {
                        if (!data) return '-';
                        return `
                            <div class="font-weight-bold text-dark">${data.singkatan || data.nama_pd}</div>
                            <small class="text-muted d-block text-truncate" style="max-width: 180px;">${data.nama_pd}</small>
                        `;
                    }
                },
                {
                    data: 'pns',
                    render: function(data) {
                        if (!data) return '<span class="badge badge-info"><i class="fas fa-warehouse mr-1"></i> Tersedia (Pool)</span>';
                        return `
                            <div class="font-weight-bold text-dark">${data.nama}</div>
                            <small class="text-muted">${data.jabatan}</small>
                        `;
                    }
                },
                {
                    data: 'kondisi',
                    className: 'text-center',
                    render: function(data) {
                        return getKondisiBadge(data);
                    }
                },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <button type="button" class="btn btn-xs btn-info" onclick="viewDetail(${row.id})" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-warning" onclick="editKdo(${row.id})" title="Ubah Data">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="deleteKdo(${row.id}, '${row.nomor_polisi}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari KDO:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                infoEmpty: "Data tidak ditemukan",
                zeroRecords: "Tidak ada kendaraan yang sesuai filter",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Sebelum"
                }
            }
        });
    }

    function openCreateModal() {
        $('#form-kdo')[0].reset();
        $('#kdo-id').val('');
        $('#perangkat_daerah_id').val('').trigger('change');
        $('#pns_id').val('').trigger('change');
        $('#kondisi').val('Baik');
        $('#status_penggunaan').val('Digunakan');
        $('#kategori').val('Roda 4');
        $('#tahun_produksi').val(new Date().getFullYear());
        $('#kdo-alert-error').addClass('d-none').html('');
        $('#modal-kdo-title').html('<i class="fas fa-plus-circle text-primary mr-1"></i> Tambah Kendaraan Dinas Operasional Baru');
        $('#modal-kdo-form').modal('show');
    }

    function editKdo(id) {
        $('#form-kdo')[0].reset();
        $('#kdo-id').val(id);
        $('#kdo-alert-error').addClass('d-none').html('');

        $.ajax({
            url: '/api/kdo/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const data = res.data;
                    $('#perangkat_daerah_id').val(data.perangkat_daerah_id).trigger('change');
                    $('#pns_id').val(data.pns_id || '').trigger('change');
                    $('#nomor_polisi').val(data.nomor_polisi);
                    $('#kode_barang').val(data.kode_barang);
                    $('#merk').val(data.merk);
                    $('#tipe').val(data.tipe);
                    $('#kategori').val(data.kategori);
                    $('#tahun_produksi').val(data.tahun_produksi);
                    $('#warna').val(data.warna);
                    $('#kondisi').val(data.kondisi);
                    $('#status_penggunaan').val(data.status_penggunaan);
                    $('#nomor_rangka').val(data.nomor_rangka);
                    $('#nomor_mesin').val(data.nomor_mesin);
                    $('#nomor_bpkb').val(data.nomor_bpkb);
                    $('#tanggal_pajak').val(data.tanggal_pajak ? data.tanggal_pajak.substring(0, 10) : '');
                    $('#keterangan').val(data.keterangan);

                    $('#modal-kdo-title').html('<i class="fas fa-edit text-warning mr-1"></i> Ubah Data KDO: ' + data.nomor_polisi);
                    $('#modal-kdo-form').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat data kendaraan.');
            }
        });
    }

    function saveKdo() {
        const id = $('#kdo-id').val();
        const url = id ? ('/api/kdo/' + id) : '/api/kdo';

        const formData = new FormData($('#form-kdo')[0]);
        if (id) {
            formData.append('_method', 'PUT');
        }

        $('#btn-save-kdo').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: url,
            type: 'POST', // Laravel handles PUT with FormData via _method
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#btn-save-kdo').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data KDO');
                if (res.success) {
                    $('#modal-kdo-form').modal('hide');
                    showToastSuccess(res.message);
                    tableKdo.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                $('#btn-save-kdo').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data KDO');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errHtml = '<ul class="mb-0 pl-3">';
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        errHtml += '<li>' + v[0] + '</li>';
                    });
                    errHtml += '</ul>';
                    $('#kdo-alert-error').removeClass('d-none').html(errHtml);
                } else {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    showToastError(msg);
                }
            }
        });
    }

    function viewDetail(id) {
        $.ajax({
            url: '/api/kdo/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const kdo = res.data;
                    $('#detail-kdo-nopol').text(kdo.nomor_polisi);
                    $('#detail-kdo-kondisi-badge').html(getKondisiBadge(kdo.kondisi));
                    $('#detail-kdo-status-badge').html(getStatusPenggunaanBadge(kdo.status_penggunaan));
                    $('#btn-print-kdo-card').attr('href', '/kdo/' + kdo.id + '/cetak-kartu');

                    // Detail Specs
                    $('#detail-kdo-pd').text(kdo.perangkat_daerah ? kdo.perangkat_daerah.nama_pd : '-');
                    $('#detail-kdo-pns').html(kdo.pns ? ('<b>' + kdo.pns.nama + '</b> (' + kdo.pns.jabatan + ' - NIP: ' + kdo.pns.nip + ')') : '<span class="text-muted font-italic">- Kendaraan Pool / Belum Ditetapkan -</span>');
                    $('#detail-kdo-merk-tipe').text(kdo.merk + ' ' + kdo.tipe);
                    $('#detail-kdo-kategori-tahun').text(kdo.kategori + ' (Tahun ' + kdo.tahun_produksi + ')');
                    $('#detail-kdo-warna').text(kdo.warna);
                    $('#detail-kdo-kode-barang').text(kdo.kode_barang || '-');
                    $('#detail-kdo-norangka').text(kdo.nomor_rangka || '-');
                    $('#detail-kdo-nomesin').text(kdo.nomor_mesin || '-');
                    $('#detail-kdo-nobpkb').text(kdo.nomor_bpkb || '-');
                    $('#detail-kdo-pajak').text(kdo.tanggal_pajak ? kdo.tanggal_pajak.substring(0, 10) : '-');
                    $('#detail-kdo-keterangan').text(kdo.keterangan || '-');

                    // Photo
                    if (kdo.foto) {
                        $('#detail-kdo-foto').attr('src', '/storage/' + kdo.foto).show();
                        $('#detail-kdo-no-foto').hide();
                    } else {
                        $('#detail-kdo-foto').hide();
                        $('#detail-kdo-no-foto').show();
                    }

                    // Render Servis Table
                    const servises = kdo.riwayat_pemeliharaans || [];
                    $('#count-servis').text(servises.length);
                    const servisTbody = $('#detail-kdo-servis-table tbody');
                    servisTbody.empty();
                    if (servises.length === 0) {
                        servisTbody.append('<tr><td colspan="6" class="text-center text-muted py-2">Belum ada riwayat pemeliharaan tercatat.</td></tr>');
                    } else {
                        servises.forEach(s => {
                            servisTbody.append(`
                                <tr>
                                    <td>${s.tanggal_servis ? s.tanggal_servis.substring(0, 10) : '-'}</td>
                                    <td class="font-weight-bold">${s.jenis_pemeliharaan}</td>
                                    <td>${s.bengkel_pelaksana || '-'}</td>
                                    <td class="text-right font-weight-bold text-success">${formatRupiah(s.biaya)}</td>
                                    <td>${getKondisiBadge(s.kondisi_sebelum)}</td>
                                    <td>${getKondisiBadge(s.kondisi_setelah)}</td>
                                </tr>
                            `);
                        });
                    }

                    // Render BAST Table
                    const basts = kdo.riwayat_pemegangs || [];
                    $('#count-bast').text(basts.length);
                    const bastTbody = $('#detail-kdo-bast-table tbody');
                    bastTbody.empty();
                    if (basts.length === 0) {
                        bastTbody.append('<tr><td colspan="7" class="text-center text-muted py-2">Belum ada histori serah terima BAST tercatat.</td></tr>');
                    } else {
                        basts.forEach(b => {
                            bastTbody.append(`
                                <tr>
                                    <td><code>${b.nomor_bast || '-'}</code></td>
                                    <td class="font-weight-bold">${b.pns ? b.pns.nama : '-'}</td>
                                    <td>${b.pns ? b.pns.jabatan : '-'}</td>
                                    <td>${b.tanggal_mulai ? b.tanggal_mulai.substring(0, 10) : '-'}</td>
                                    <td>${b.tanggal_selesai ? b.tanggal_selesai.substring(0, 10) : '<span class="text-success font-weight-bold">Aktif Saat Ini</span>'}</td>
                                    <td><span class="badge ${b.status_bast === 'Aktif' ? 'badge-success' : 'badge-secondary'}">${b.status_bast}</span></td>
                                    <td><small class="text-muted">${b.catatan || '-'}</small></td>
                                </tr>
                            `);
                        });
                    }

                    $('#modal-kdo-detail').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat detail kendaraan.');
            }
        });
    }

    function deleteKdo(id, nopol) {
        Swal.fire({
            title: 'Hapus Kendaraan Dinas?',
            text: 'Apakah Anda yakin ingin menghapus data KDO dengan nomor polisi ' + nopol + '? Tindakan ini juga akan menghapus riwayat pemeliharaan dan BAST terkait.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/kdo/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            showToastSuccess(res.message);
                            tableKdo.ajax.reload(null, false);
                        }
                    },
                    error: function(xhr) {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal menghapus data KDO.';
                        showToastError(msg);
                    }
                });
            }
        });
    }
</script>
@endpush
