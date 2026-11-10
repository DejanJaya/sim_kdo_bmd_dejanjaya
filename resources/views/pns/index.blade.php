@extends('layouts.app')

@section('title', 'Pegawai (PNS)')
@section('page_title', 'Kelola Pegawai Negeri Sipil (PNS)')

@section('breadcrumb')
<li class="breadcrumb-item active">Pegawai (PNS)</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filter Card -->
        <div class="card card-outline card-success shadow-sm mb-3">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-landmark mr-1"></i> Filter Perangkat Daerah (PD):</label>
                        <select id="filter-pd" class="form-control form-control-sm select2">
                            <option value="">-- Seluruh Perangkat Daerah --</option>
                            @foreach($perangkatDaerahs as $pd)
                                <option value="{{ $pd->id }}">{{ $pd->nama_pd }} ({{ $pd->singkatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-user-check mr-1"></i> Status Kepegawaian:</label>
                        <select id="filter-status" class="form-control form-control-sm">
                            <option value="">-- Seluruh Status --</option>
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Pensiun">Pensiun</option>
                            <option value="Mutasi">Mutasi</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-1" onclick="resetFilters()">
                            <i class="fas fa-undo mr-1"></i> Reset
                        </button>
                        <button type="button" class="btn btn-sm btn-success font-weight-bold shadow-sm" onclick="openCreateModal()">
                            <i class="fas fa-plus-circle mr-1"></i> Tambah PNS
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card Data -->
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-tie text-success mr-1"></i>
                    Daftar Pegawai Penanggung Jawab KDO
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="table-pns" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">NIP</th>
                                <th style="width: 22%;">Nama Lengkap</th>
                                <th style="width: 20%;">Perangkat Daerah</th>
                                <th style="width: 18%;">Jabatan</th>
                                <th style="width: 10%;">Golongan</th>
                                <th style="width: 8%;" class="text-center">KDO Aktif</th>
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

<!-- Modal Form Tambah / Edit PNS -->
<div class="modal fade" id="modal-pns-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-pns-title">
                    <i class="fas fa-user-tie mr-1"></i> Form Pegawai (PNS)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-pns">
                <input type="hidden" id="pns-id" name="id">
                <div class="modal-body">
                    <div id="pns-alert-error" class="alert alert-danger d-none"></div>

                    <div class="form-group">
                        <label for="perangkat_daerah_id">Perangkat Daerah (Instansi) <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="perangkat_daerah_id" name="perangkat_daerah_id" required style="width: 100%;">
                            <option value="">-- Pilih Perangkat Daerah --</option>
                            @foreach($perangkatDaerahs as $pd)
                                <option value="{{ $pd->id }}">{{ $pd->nama_pd }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP Pegawai <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" 
                                       placeholder="Format: 19xxxxxxxxxxxxxxx (18 digit)" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       placeholder="Nama lengkap pegawai" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="jabatan">Jabatan Struktural / Fungsional <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" 
                                       placeholder="Contoh: Kepala Dinas, Sekretaris, Kasubag Umum" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="golongan">Pangkat / Golongan Ruang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="golongan" name="golongan" 
                                       placeholder="Contoh: Pembina (IV/a), Penata (III/c)" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="no_telepon">No. Telepon / WhatsApp</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" 
                                       placeholder="Contoh: 081234567890">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="email">Alamat Email Kedinasan</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       placeholder="nama.pegawai@pemda.go.id">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_pegawai">Status Pegawai <span class="text-danger">*</span></label>
                                <select class="form-control" id="status_pegawai" name="status_pegawai" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Pensiun">Pensiun</option>
                                    <option value="Mutasi">Mutasi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success" id="btn-save-pns">
                        <i class="fas fa-save mr-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail PNS -->
<div class="modal fade" id="modal-pns-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="detail-pns-title">Detail Pegawai (PNS)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-widget widget-user-2 shadow-none border mb-3">
                    <div class="widget-user-header bg-light">
                        <div class="widget-user-image">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 1.8rem;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <h4 class="widget-user-username font-weight-bold" id="detail-pns-nama">-</h4>
                        <h6 class="widget-user-desc text-muted mb-0" id="detail-pns-jabatan-instansi">-</h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm table-striped mb-0">
                            <tr>
                                <th style="width: 30%;">NIP:</th>
                                <td id="detail-pns-nip"><code>-</code></td>
                            </tr>
                            <tr>
                                <th>Pangkat / Golongan:</th>
                                <td id="detail-pns-golongan">-</td>
                            </tr>
                            <tr>
                                <th>Kontak / Email:</th>
                                <td id="detail-pns-kontak">-</td>
                            </tr>
                            <tr>
                                <th>Status Kepegawaian:</th>
                                <td id="detail-pns-status">-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h6 class="font-weight-bold text-dark mt-4 mb-2">
                    <i class="fas fa-car mr-1 text-primary"></i>
                    Kendaraan Dinas (KDO) yang Sedang Dipegang / Dipertanggungjawabkan:
                </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover" id="detail-pns-kdo-table">
                        <thead class="bg-light">
                            <tr>
                                <th>No. Polisi</th>
                                <th>Kendaraan</th>
                                <th>Tahun</th>
                                <th>Kondisi</th>
                                <th>Jatuh Tempo Pajak</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <h6 class="font-weight-bold text-dark mt-4 mb-2">
                    <i class="fas fa-history mr-1 text-secondary"></i>
                    Histori Penugasan / BAST Pemegang:
                </h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover" id="detail-pns-bast-table">
                        <thead class="bg-light">
                            <tr>
                                <th>No. BAST</th>
                                <th>Kendaraan</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status BAST</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
    let tablePns = null;

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        initDataTable();

        $('#filter-pd, #filter-status').on('change', function() {
            tablePns.ajax.reload();
        });

        $('#form-pns').on('submit', function(e) {
            e.preventDefault();
            savePns();
        });
    });

    function resetFilters() {
        $('#filter-pd').val('').trigger('change');
        $('#filter-status').val('Aktif').trigger('change');
    }

    function initDataTable() {
        tablePns = $('#table-pns').DataTable({
            processing: true,
            responsive: true,
            ajax: {
                url: '/api/pns',
                type: 'GET',
                data: function(d) {
                    d.perangkat_daerah_id = $('#filter-pd').val();
                    d.status_pegawai = $('#filter-status').val();
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
                    data: 'nip',
                    render: function(data) {
                        return '<code>' + data + '</code>';
                    }
                },
                {
                    data: 'nama',
                    render: function(data, type, row) {
                        return '<div class="font-weight-bold text-dark">' + data + '</div><small class="text-muted">' + (row.email || '') + '</small>';
                    }
                },
                {
                    data: 'perangkat_daerah',
                    render: function(data) {
                        return data ? data.nama_pd : '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'jabatan'
                },
                {
                    data: 'golongan',
                    render: function(data) {
                        return '<span class="badge badge-light border">' + data + '</span>';
                    }
                },
                {
                    data: 'kdos_count',
                    className: 'text-center',
                    render: function(data) {
                        if (data > 0) {
                            return '<span class="badge badge-primary px-2 py-1"><i class="fas fa-car mr-1"></i> ' + data + ' Unit</span>';
                        }
                        return '<span class="badge badge-light text-muted">-</span>';
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
                            <button type="button" class="btn btn-xs btn-warning" onclick="editPns(${row.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-xs btn-danger" onclick="deletePns(${row.id}, '${row.nama}')" title="Hapus">
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
        $('#form-pns')[0].reset();
        $('#pns-id').val('');
        $('#perangkat_daerah_id').val('').trigger('change');
        $('#status_pegawai').val('Aktif');
        $('#pns-alert-error').addClass('d-none').html('');
        $('#modal-pns-title').html('<i class="fas fa-user-plus text-success mr-1"></i> Tambah Pegawai (PNS) Baru');
        $('#modal-pns-form').modal('show');
    }

    function editPns(id) {
        $('#form-pns')[0].reset();
        $('#pns-id').val(id);
        $('#pns-alert-error').addClass('d-none').html('');

        $.ajax({
            url: '/api/pns/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const data = res.data;
                    $('#perangkat_daerah_id').val(data.perangkat_daerah_id).trigger('change');
                    $('#nip').val(data.nip);
                    $('#nama').val(data.nama);
                    $('#jabatan').val(data.jabatan);
                    $('#golongan').val(data.golongan);
                    $('#no_telepon').val(data.no_telepon);
                    $('#email').val(data.email);
                    $('#status_pegawai').val(data.status_pegawai);

                    $('#modal-pns-title').html('<i class="fas fa-edit text-warning mr-1"></i> Ubah Pegawai: ' + data.nama);
                    $('#modal-pns-form').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat data pegawai.');
            }
        });
    }

    function savePns() {
        const id = $('#pns-id').val();
        const url = id ? ('/api/pns/' + id) : '/api/pns';
        const method = id ? 'PUT' : 'POST';

        const payload = {
            perangkat_daerah_id: $('#perangkat_daerah_id').val(),
            nip: $('#nip').val(),
            nama: $('#nama').val(),
            jabatan: $('#jabatan').val(),
            golongan: $('#golongan').val(),
            no_telepon: $('#no_telepon').val(),
            email: $('#email').val(),
            status_pegawai: $('#status_pegawai').val(),
        };

        $('#btn-save-pns').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: url,
            type: method,
            data: JSON.stringify(payload),
            contentType: 'application/json',
            success: function(res) {
                $('#btn-save-pns').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data');
                if (res.success) {
                    $('#modal-pns-form').modal('hide');
                    showToastSuccess(res.message);
                    tablePns.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                $('#btn-save-pns').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errHtml = '<ul class="mb-0 pl-3">';
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        errHtml += '<li>' + v[0] + '</li>';
                    });
                    errHtml += '</ul>';
                    $('#pns-alert-error').removeClass('d-none').html(errHtml);
                } else {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    showToastError(msg);
                }
            }
        });
    }

    function viewDetail(id) {
        $.ajax({
            url: '/api/pns/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const pns = res.data;
                    $('#detail-pns-nama').text(pns.nama);
                    $('#detail-pns-jabatan-instansi').text(pns.jabatan + ' - ' + (pns.perangkat_daerah ? pns.perangkat_daerah.nama_pd : ''));
                    $('#detail-pns-nip').html('<code>' + pns.nip + '</code>');
                    $('#detail-pns-golongan').text(pns.golongan);
                    $('#detail-pns-kontak').text((pns.no_telepon ? pns.no_telepon + ' / ' : '') + (pns.email || '-'));
                    $('#detail-pns-status').html('<span class="badge badge-success">' + pns.status_pegawai + '</span>');

                    // Render KDO Aktif
                    const kdos = pns.kdos || [];
                    const kdoTbody = $('#detail-pns-kdo-table tbody');
                    kdoTbody.empty();
                    if (kdos.length === 0) {
                        kdoTbody.append('<tr><td colspan="5" class="text-center text-muted py-2">Pegawai ini tidak sedang memegang KDO dinas.</td></tr>');
                    } else {
                        kdos.forEach(k => {
                            kdoTbody.append(`
                                <tr>
                                    <td><span class="font-weight-bold text-primary">${k.nomor_polisi}</span></td>
                                    <td>${k.merk} ${k.tipe}</td>
                                    <td>${k.tahun_produksi}</td>
                                    <td>${getKondisiBadge(k.kondisi)}</td>
                                    <td>${k.tanggal_pajak ? k.tanggal_pajak.substring(0, 10) : '-'}</td>
                                </tr>
                            `);
                        });
                    }

                    // Render Riwayat BAST
                    const basts = pns.riwayat_pemegangs || [];
                    const bastTbody = $('#detail-pns-bast-table tbody');
                    bastTbody.empty();
                    if (basts.length === 0) {
                        bastTbody.append('<tr><td colspan="5" class="text-center text-muted py-2">Belum ada riwayat BAST tercatat.</td></tr>');
                    } else {
                        basts.forEach(b => {
                            bastTbody.append(`
                                <tr>
                                    <td><code>${b.nomor_bast || '-'}</code></td>
                                    <td>${b.kdo ? (b.kdo.nomor_polisi + ' - ' + b.kdo.merk + ' ' + b.kdo.tipe) : '-'}</td>
                                    <td>${b.tanggal_mulai ? b.tanggal_mulai.substring(0, 10) : '-'}</td>
                                    <td>${b.tanggal_selesai ? b.tanggal_selesai.substring(0, 10) : '<span class="text-success font-weight-bold">Sekarang</span>'}</td>
                                    <td><span class="badge ${b.status_bast === 'Aktif' ? 'badge-success' : 'badge-secondary'}">${b.status_bast}</span></td>
                                </tr>
                            `);
                        });
                    }

                    $('#modal-pns-detail').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat detail pegawai.');
            }
        });
    }

    function deletePns(id, nama) {
        Swal.fire({
            title: 'Hapus Pegawai (PNS)?',
            text: 'Apakah Anda yakin ingin menghapus data pegawai ' + nama + '? Jika pegawai ini masih memegang KDO aktif, penghapusan akan dicegah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/pns/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            showToastSuccess(res.message);
                            tablePns.ajax.reload(null, false);
                        }
                    },
                    error: function(xhr) {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) 
                            ? xhr.responseJSON.message 
                            : 'Gagal menghapus data pegawai.';
                        showToastError(msg);
                    }
                });
            }
        });
    }
</script>
@endpush
