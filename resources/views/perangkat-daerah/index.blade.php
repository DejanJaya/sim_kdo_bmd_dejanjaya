@extends('layouts.app')

@section('title', 'Perangkat Daerah')
@section('page_title', 'Kelola Perangkat Daerah (PD)')

@section('breadcrumb')
<li class="breadcrumb-item active">Perangkat Daerah</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">
                    <i class="fas fa-landmark text-warning mr-1"></i>
                    Daftar Satuan Kerja Perangkat Daerah (SKPD / OPD)
                </h3>
                <div class="card-tools ml-auto">
                    <button type="button" class="btn btn-warning text-dark font-weight-bold btn-sm shadow-sm" onclick="openCreateModal()">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Perangkat Daerah
                    </button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="table-pd" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 18%;">Kode PD</th>
                                <th style="width: 25%;">Nama Perangkat Daerah</th>
                                <th style="width: 10%;">Singkatan</th>
                                <th style="width: 22%;">Kepala Dinas</th>
                                <th style="width: 8%;" class="text-center">PNS</th>
                                <th style="width: 8%;" class="text-center">KDO</th>
                                <th style="width: 14%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Tambah / Edit PD -->
<div class="modal fade" id="modal-pd-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-pd-title">
                    <i class="fas fa-landmark mr-1"></i> Form Perangkat Daerah
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-pd">
                <input type="hidden" id="pd-id" name="id">
                <div class="modal-body">
                    <div id="pd-alert-error" class="alert alert-danger d-none"></div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="kode_pd">Kode Perangkat Daerah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="kode_pd" name="kode_pd" 
                                       placeholder="Contoh: 1.01.0.00.0.00.01.0000" required>
                                <small class="text-muted">Kode unik standar klasifikasi OPD/SKPD.</small>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="singkatan">Singkatan / Akronim</label>
                                <input type="text" class="form-control" id="singkatan" name="singkatan" 
                                       placeholder="Contoh: Disdik, Dinkes">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nama_pd">Nama Lengkap Perangkat Daerah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_pd" name="nama_pd" 
                               placeholder="Contoh: Dinas Pendidikan" required>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="nama_kepala">Nama Kepala Dinas / Pimpinan</label>
                                <input type="text" class="form-control" id="nama_kepala" name="nama_kepala" 
                                       placeholder="Nama lengkap beserta gelar akademik">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nip_kepala">NIP Kepala Dinas</label>
                                <input type="text" class="form-control" id="nip_kepala" name="nip_kepala" 
                                       placeholder="Format: 19xxxxxxxxxxxxxxx">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="alamat">Alamat Kantor</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2" 
                                          placeholder="Alamat domisili kantor dinas"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="telepon">No. Telepon Kantor</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" 
                                       placeholder="Contoh: (021) 8765432">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn-save-pd">
                        <i class="fas fa-save mr-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail PD -->
<div class="modal fade" id="modal-pd-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="detail-pd-nama">Detail Perangkat Daerah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" style="width: 35%;">Kode OPD:</td>
                                <td class="font-weight-bold" id="detail-pd-kode">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Nama Instansi:</td>
                                <td class="font-weight-bold" id="detail-pd-nama-text">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Singkatan:</td>
                                <td id="detail-pd-singkatan">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted" style="width: 35%;">Kepala Dinas:</td>
                                <td class="font-weight-bold" id="detail-pd-kepala">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIP Kepala:</td>
                                <td id="detail-pd-nip">-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Telepon / Alamat:</td>
                                <td id="detail-pd-kontak">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Tabs: Pegawai & Kendaraan -->
                <ul class="nav nav-tabs font-weight-bold" id="pd-detail-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-pd-kdo-link" data-toggle="tab" href="#tab-pd-kdo" role="tab">
                            <i class="fas fa-car mr-1 text-primary"></i> Daftar KDO Milik PD (<span id="count-kdo">0</span>)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-pd-pns-link" data-toggle="tab" href="#tab-pd-pns" role="tab">
                            <i class="fas fa-users mr-1 text-success"></i> Daftar Pegawai / PNS (<span id="count-pns">0</span>)
                        </a>
                    </li>
                </ul>

                <div class="tab-content pt-3" id="pd-detail-tabs-content">
                    <!-- Tab KDO -->
                    <div class="tab-pane fade show active" id="tab-pd-kdo" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover mb-0" id="detail-table-kdo">
                                <thead class="bg-light">
                                    <tr>
                                        <th>No. Polisi</th>
                                        <th>Merk & Tipe</th>
                                        <th>Tahun</th>
                                        <th>Kondisi</th>
                                        <th>Status Penggunaan</th>
                                        <th>Pemegang / Penanggung Jawab</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab PNS -->
                    <div class="tab-pane fade" id="tab-pd-pns" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover mb-0" id="detail-table-pns">
                                <thead class="bg-light">
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th>Golongan</th>
                                        <th>No. Telepon</th>
                                        <th>Status</th>
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
    let tablePd = null;

    $(document).ready(function() {
        initDataTable();

        $('#form-pd').on('submit', function(e) {
            e.preventDefault();
            savePerangkatDaerah();
        });
    });

    function initDataTable() {
        tablePd = $('#table-pd').DataTable({
            processing: true,
            responsive: true,
            ajax: {
                url: '/api/perangkat-daerah',
                type: 'GET',
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
                    data: 'kode_pd',
                    render: function(data) {
                        return '<code>' + data + '</code>';
                    }
                },
                {
                    data: 'nama_pd',
                    render: function(data, type, row) {
                        return '<span class="font-weight-bold text-dark">' + data + '</span>';
                    }
                },
                {
                    data: 'singkatan',
                    render: function(data) {
                        return data ? '<span class="badge badge-light border">' + data + '</span>' : '-';
                    }
                },
                {
                    data: 'nama_kepala',
                    render: function(data, type, row) {
                        if (!data) return '<span class="text-muted font-italic">- Belum Diatur -</span>';
                        return '<div>' + data + '</div><small class="text-muted">NIP: ' + (row.nip_kepala || '-') + '</small>';
                    }
                },
                {
                    data: 'pns_count',
                    className: 'text-center',
                    render: function(data) {
                        return '<span class="badge badge-success px-2 py-1">' + (data || 0) + ' Orang</span>';
                    }
                },
                {
                    data: 'kdos_count',
                    className: 'text-center',
                    render: function(data) {
                        return '<span class="badge badge-primary px-2 py-1">' + (data || 0) + ' Unit</span>';
                    }
                },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <button type="button" class="btn btn-xs btn-info" onclick="viewDetail(${row.id})" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-warning" onclick="editPd(${row.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="deletePd(${row.id}, '${row.nama_pd}')" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                infoEmpty: "Data tidak ditemukan",
                zeroRecords: "Tidak ada data yang cocok",
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
        $('#form-pd')[0].reset();
        $('#pd-id').val('');
        $('#pd-alert-error').addClass('d-none').html('');
        $('#modal-pd-title').html('<i class="fas fa-plus-circle text-warning mr-1"></i> Tambah Perangkat Daerah Baru');
        $('#modal-pd-form').modal('show');
    }

    function editPd(id) {
        $('#form-pd')[0].reset();
        $('#pd-id').val(id);
        $('#pd-alert-error').addClass('d-none').html('');

        $.ajax({
            url: '/api/perangkat-daerah/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const data = res.data;
                    $('#kode_pd').val(data.kode_pd);
                    $('#nama_pd').val(data.nama_pd);
                    $('#singkatan').val(data.singkatan);
                    $('#nama_kepala').val(data.nama_kepala);
                    $('#nip_kepala').val(data.nip_kepala);
                    $('#telepon').val(data.telepon);
                    $('#alamat').val(data.alamat);

                    $('#modal-pd-title').html('<i class="fas fa-edit text-warning mr-1"></i> Ubah Data: ' + data.nama_pd);
                    $('#modal-pd-form').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal mengambil data perangkat daerah.');
            }
        });
    }

    function savePerangkatDaerah() {
        const id = $('#pd-id').val();
        const url = id ? ('/api/perangkat-daerah/' + id) : '/api/perangkat-daerah';
        const method = id ? 'PUT' : 'POST';

        const payload = {
            kode_pd: $('#kode_pd').val(),
            nama_pd: $('#nama_pd').val(),
            singkatan: $('#singkatan').val(),
            nama_kepala: $('#nama_kepala').val(),
            nip_kepala: $('#nip_kepala').val(),
            telepon: $('#telepon').val(),
            alamat: $('#alamat').val(),
        };

        $('#btn-save-pd').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(payload),
            contentType: 'application/json',
            success: function(res) {
                $('#btn-save-pd').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data');
                if (res.success) {
                    $('#modal-pd-form').modal('hide');
                    showToastSuccess(res.message);
                    tablePd.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                $('#btn-save-pd').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errHtml = '<ul class="mb-0 pl-3">';
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        errHtml += '<li>' + v[0] + '</li>';
                    });
                    errHtml += '</ul>';
                    $('#pd-alert-error').removeClass('d-none').html(errHtml);
                } else {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    showToastError(msg);
                }
            }
        });
    }

    function viewDetail(id) {
        $.ajax({
            url: '/api/perangkat-daerah/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const data = res.data;
                    $('#detail-pd-nama').text(data.nama_pd);
                    $('#detail-pd-nama-text').text(data.nama_pd);
                    $('#detail-pd-kode').html('<code>' + data.kode_pd + '</code>');
                    $('#detail-pd-singkatan').text(data.singkatan || '-');
                    $('#detail-pd-kepala').text(data.nama_kepala || '-');
                    $('#detail-pd-nip').text(data.nip_kepala || '-');
                    $('#detail-pd-kontak').text((data.telepon ? data.telepon + ' / ' : '') + (data.alamat || '-'));

                    // Render KDO
                    const kdoList = data.kdos || [];
                    $('#count-kdo').text(kdoList.length);
                    const tbodyKdo = $('#detail-table-kdo tbody');
                    tbodyKdo.empty();
                    if (kdoList.length === 0) {
                        tbodyKdo.append('<tr><td colspan="6" class="text-center text-muted py-2">Belum ada KDO terdaftar di PD ini.</td></tr>');
                    } else {
                        kdoList.forEach(k => {
                            tbodyKdo.append(`
                                <tr>
                                    <td><span class="font-weight-bold text-primary">${k.nomor_polisi}</span></td>
                                    <td>${k.merk} ${k.tipe}</td>
                                    <td>${k.tahun_produksi}</td>
                                    <td>${getKondisiBadge(k.kondisi)}</td>
                                    <td>${getStatusPenggunaanBadge(k.status_penggunaan)}</td>
                                    <td>${k.pns ? ('<b>' + k.pns.nama + '</b> (' + k.pns.jabatan + ')') : '<span class="text-muted font-italic">- Tersedia/Pool -</span>'}</td>
                                </tr>
                            `);
                        });
                    }

                    // Render PNS
                    const pnsList = data.pns || [];
                    $('#count-pns').text(pnsList.length);
                    const tbodyPns = $('#detail-table-pns tbody');
                    tbodyPns.empty();
                    if (pnsList.length === 0) {
                        tbodyPns.append('<tr><td colspan="6" class="text-center text-muted py-2">Belum ada data PNS di PD ini.</td></tr>');
                    } else {
                        pnsList.forEach(p => {
                            tbodyPns.append(`
                                <tr>
                                    <td><code>${p.nip}</code></td>
                                    <td class="font-weight-bold">${p.nama}</td>
                                    <td>${p.jabatan}</td>
                                    <td>${p.golongan}</td>
                                    <td>${p.no_telepon || '-'}</td>
                                    <td><span class="badge badge-success">${p.status_pegawai}</span></td>
                                </tr>
                            `);
                        });
                    }

                    $('#modal-pd-detail').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat detail perangkat daerah.');
            }
        });
    }

    function deletePd(id, nama) {
        Swal.fire({
            title: 'Hapus Perangkat Daerah?',
            text: 'Apakah Anda yakin ingin menghapus ' + nama + '? Data yang masih memiliki pegawai atau kendaraan terkait tidak dapat dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/perangkat-daerah/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            showToastSuccess(res.message);
                            tablePd.ajax.reload(null, false);
                        }
                    },
                    error: function(xhr) {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) 
                            ? xhr.responseJSON.message 
                            : 'Gagal menghapus data perangkat daerah.';
                        showToastError(msg);
                    }
                });
            }
        });
    }
</script>
@endpush
