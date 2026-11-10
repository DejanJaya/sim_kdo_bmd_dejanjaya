@extends('layouts.app')

@section('title', 'Riwayat Pemeliharaan')
@section('page_title', 'Kelola Riwayat Pemeliharaan & Servis KDO')

@section('breadcrumb')
<li class="breadcrumb-item active">Riwayat Pemeliharaan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Filter Card -->
        <div class="card card-outline card-danger shadow-sm mb-3">
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-car mr-1"></i> Filter Berdasarkan Kendaraan Dinas (KDO):</label>
                        <select id="filter-kdo" class="form-control form-control-sm select2">
                            <option value="">-- Seluruh Kendaraan Dinas --</option>
                            @foreach($kdos as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nomor_polisi }} - {{ $k->merk }} {{ $k->tipe }} ({{ $k->perangkatDaerah->singkatan ?? $k->perangkatDaerah->nama_pd }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 text-md-right mt-3 mt-md-0">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-1" onclick="resetFilters()">
                            <i class="fas fa-undo mr-1"></i> Reset
                        </button>
                        <button type="button" class="btn btn-sm btn-danger font-weight-bold shadow-sm" onclick="openCreateModal()">
                            <i class="fas fa-plus-circle mr-1"></i> Catat Pemeliharaan / Servis
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card Data -->
        <div class="card card-outline card-danger shadow-sm">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tools text-danger mr-1"></i>
                    Buku Catatan Pemeliharaan Fisik Kendaraan Dinas (BMD)
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="table-pemeliharaan" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 15%;">No. Polisi / KDO</th>
                                <th style="width: 23%;">Jenis Pemeliharaan</th>
                                <th style="width: 18%;">Bengkel Pelaksana</th>
                                <th style="width: 12%;" class="text-right">Biaya (Rp)</th>
                                <th style="width: 8%;" class="text-center">Kondisi</th>
                                <th style="width: 7%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Tambah / Edit Pemeliharaan -->
<div class="modal fade" id="modal-pemeliharaan-form" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modal-pemeliharaan-title">
                    <i class="fas fa-tools text-danger mr-1"></i> Catat Pemeliharaan Kendaraan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-pemeliharaan" enctype="multipart/form-data">
                <input type="hidden" id="pemeliharaan-id" name="id">
                <div class="modal-body">
                    <div id="pemeliharaan-alert-error" class="alert alert-danger d-none"></div>

                    <div class="form-group">
                        <label for="kdo_id">Pilih Kendaraan Dinas Operasional (KDO) <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="kdo_id" name="kdo_id" required style="width: 100%;">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($kdos as $k)
                                <option value="{{ $k->id }}">
                                    {{ $k->nomor_polisi }} - {{ $k->merk }} {{ $k->tipe }} (Kondisi Saat Ini: {{ $k->kondisi }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_servis">Tanggal Servis / Pemeliharaan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_servis" name="tanggal_servis" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="biaya">Biaya Pemeliharaan (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="biaya" name="biaya" 
                                       min="0" step="1000" placeholder="Contoh: 1500000" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_pemeliharaan">Jenis Pemeliharaan / Pekerjaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jenis_pemeliharaan" name="jenis_pemeliharaan" 
                                       placeholder="Contoh: Servis Berkala & Ganti Oli, Perbaikan Rem" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bengkel_pelaksana">Bengkel Pelaksana / Rekanan</label>
                                <input type="text" class="form-control" id="bengkel_pelaksana" name="bengkel_pelaksana" 
                                       placeholder="Contoh: Bengkel Auto2000, Toko Ban Bridgestone">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kondisi_sebelum">Kondisi Sebelum Servis <span class="text-danger">*</span></label>
                                <select class="form-control" id="kondisi_sebelum" name="kondisi_sebelum" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan" selected>Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kondisi_setelah">Kondisi Setelah Servis (Hasil) <span class="text-danger">*</span></label>
                                <select class="form-control" id="kondisi_setelah" name="kondisi_setelah" required>
                                    <option value="Baik" selected>Baik (Pulih Operasional)</option>
                                    <option value="Rusak Ringan">Rusak Ringan (Masih Ada Kendala)</option>
                                    <option value="Rusak Berat">Rusak Berat (Gagal Perbaikan)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="update_kdo_kondisi" name="update_kdo_kondisi" value="1" checked>
                            <label class="custom-control-label font-weight-normal" for="update_kdo_kondisi">
                                <b>Otomatis perbarui kondisi fisik utama KDO</b> sesuai hasil kondisi setelah servis.
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Uraian Pekerjaan / Rincian Suku Cadang</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2" 
                                  placeholder="Rincian suku cadang yang diganti, nomor invoice, dan keterangan mekanik"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="bukti_dokumen">Bukti Kuitansi / Faktur Bengkel (Opsional)</label>
                        <input type="file" class="form-control-file" id="bukti_dokumen" name="bukti_dokumen" accept="image/*,.pdf">
                        <small class="text-muted">Format: JPG, PNG, PDF maks 4MB</small>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger" id="btn-save-pemeliharaan">
                        <i class="fas fa-save mr-1"></i> Simpan Catatan Servis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Pemeliharaan -->
<div class="modal fade" id="modal-pemeliharaan-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="detail-pemeliharaan-title">Detail Riwayat Pemeliharaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-striped">
                    <tr>
                        <th style="width: 35%;">Kendaraan Dinas (KDO):</th>
                        <td id="detail-m-kdo" class="font-weight-bold">-</td>
                    </tr>
                    <tr>
                        <th>Perangkat Daerah:</th>
                        <td id="detail-m-pd">-</td>
                    </tr>
                    <tr>
                        <th>Tanggal Servis:</th>
                        <td id="detail-m-tanggal">-</td>
                    </tr>
                    <tr>
                        <th>Jenis Pemeliharaan:</th>
                        <td id="detail-m-jenis" class="font-weight-bold">-</td>
                    </tr>
                    <tr>
                        <th>Bengkel Pelaksana:</th>
                        <td id="detail-m-bengkel">-</td>
                    </tr>
                    <tr>
                        <th>Biaya Pemeliharaan:</th>
                        <td id="detail-m-biaya" class="font-weight-bold text-success h6 mb-0">-</td>
                    </tr>
                    <tr>
                        <th>Perubahan Kondisi Fisik:</th>
                        <td id="detail-m-perubahan-kondisi">-</td>
                    </tr>
                    <tr>
                        <th>Rincian Deskripsi:</th>
                        <td id="detail-m-deskripsi">-</td>
                    </tr>
                    <tr>
                        <th>Bukti Kuitansi / Faktur:</th>
                        <td id="detail-m-dokumen">-</td>
                    </tr>
                </table>
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
    let tablePemeliharaan = null;

    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        initDataTable();

        $('#filter-kdo').on('change', function() {
            tablePemeliharaan.ajax.reload();
        });

        $('#form-pemeliharaan').on('submit', function(e) {
            e.preventDefault();
            savePemeliharaan();
        });
    });

    function resetFilters() {
        $('#filter-kdo').val('').trigger('change');
        tablePemeliharaan.ajax.reload();
    }

    function initDataTable() {
        tablePemeliharaan = $('#table-pemeliharaan').DataTable({
            processing: true,
            responsive: true,
            ajax: {
                url: '/api/riwayat-pemeliharaan',
                type: 'GET',
                data: function(d) {
                    d.kdo_id = $('#filter-kdo').val();
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
                    data: 'tanggal_servis',
                    render: function(data) {
                        return data ? data.substring(0, 10) : '-';
                    }
                },
                {
                    data: 'kdo',
                    render: function(data) {
                        if (!data) return '-';
                        return `
                            <div class="font-weight-bold text-primary">${data.nomor_polisi}</div>
                            <small class="text-muted">${data.merk} ${data.tipe}</small>
                        `;
                    }
                },
                {
                    data: 'jenis_pemeliharaan',
                    render: function(data) {
                        return '<div class="font-weight-bold text-dark">' + data + '</div>';
                    }
                },
                {
                    data: 'bengkel_pelaksana',
                    render: function(data) {
                        return data || '<span class="text-muted font-italic">- Internal/Tidak Tercatat -</span>';
                    }
                },
                {
                    data: 'biaya',
                    className: 'text-right font-weight-bold text-success',
                    render: function(data) {
                        return formatRupiah(data);
                    }
                },
                {
                    data: 'kondisi_setelah',
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
                            <button type="button" class="btn btn-xs btn-danger" onclick="deletePemeliharaan(${row.id})" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari Servis:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
                infoEmpty: "Data tidak ditemukan",
                zeroRecords: "Tidak ada riwayat servis yang sesuai",
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
        $('#form-pemeliharaan')[0].reset();
        $('#pemeliharaan-id').val('');
        $('#kdo_id').val('').trigger('change');
        $('#kondisi_sebelum').val('Rusak Ringan');
        $('#kondisi_setelah').val('Baik');
        $('#update_kdo_kondisi').prop('checked', true);
        $('#pemeliharaan-alert-error').addClass('d-none').html('');
        $('#modal-pemeliharaan-title').html('<i class="fas fa-plus-circle text-danger mr-1"></i> Catat Pemeliharaan Kendaraan Baru');
        $('#modal-pemeliharaan-form').modal('show');
    }

    function savePemeliharaan() {
        const formData = new FormData($('#form-pemeliharaan')[0]);

        $('#btn-save-pemeliharaan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

        $.ajax({
            url: '/api/riwayat-pemeliharaan',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                $('#btn-save-pemeliharaan').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Catatan Servis');
                if (res.success) {
                    $('#modal-pemeliharaan-form').modal('hide');
                    showToastSuccess(res.message);
                    tablePemeliharaan.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                $('#btn-save-pemeliharaan').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Catatan Servis');
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    let errHtml = '<ul class="mb-0 pl-3">';
                    $.each(xhr.responseJSON.errors, function(k, v) {
                        errHtml += '<li>' + v[0] + '</li>';
                    });
                    errHtml += '</ul>';
                    $('#pemeliharaan-alert-error').removeClass('d-none').html(errHtml);
                } else {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    showToastError(msg);
                }
            }
        });
    }

    function viewDetail(id) {
        $.ajax({
            url: '/api/riwayat-pemeliharaan/' + id,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const item = res.data;
                    const kdo = item.kdo || {};
                    $('#detail-m-kdo').html('<span class="text-primary font-weight-bold">' + kdo.nomor_polisi + '</span> (' + kdo.merk + ' ' + kdo.tipe + ')');
                    $('#detail-m-pd').text(kdo.perangkat_daerah ? kdo.perangkat_daerah.nama_pd : '-');
                    $('#detail-m-tanggal').text(item.tanggal_servis ? item.tanggal_servis.substring(0, 10) : '-');
                    $('#detail-m-jenis').text(item.jenis_pemeliharaan);
                    $('#detail-m-bengkel').text(item.bengkel_pelaksana || '-');
                    $('#detail-m-biaya').text(formatRupiah(item.biaya));
                    $('#detail-m-perubahan-kondisi').html(getKondisiBadge(item.kondisi_sebelum) + ' <i class="fas fa-arrow-right mx-2 text-muted"></i> ' + getKondisiBadge(item.kondisi_setelah));
                    $('#detail-m-deskripsi').text(item.deskripsi || '-');

                    if (item.bukti_dokumen) {
                        $('#detail-m-dokumen').html('<a href="/storage/' + item.bukti_dokumen + '" target="_blank" class="btn btn-xs btn-primary"><i class="fas fa-file-download mr-1"></i> Buka Lampiran Dokumen</a>');
                    } else {
                        $('#detail-m-dokumen').html('<span class="text-muted font-italic">- Tidak ada dokumen terlampir -</span>');
                    }

                    $('#modal-pemeliharaan-detail').modal('show');
                }
            },
            error: function() {
                showToastError('Gagal memuat detail riwayat servis.');
            }
        });
    }

    function deletePemeliharaan(id) {
        Swal.fire({
            title: 'Hapus Catatan Servis?',
            text: 'Apakah Anda yakin ingin menghapus catatan riwayat pemeliharaan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-trash mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/riwayat-pemeliharaan/' + id,
                    type: 'DELETE',
                    success: function(res) {
                        if (res.success) {
                            showToastSuccess(res.message);
                            tablePemeliharaan.ajax.reload(null, false);
                        }
                    },
                    error: function(xhr) {
                        const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Gagal menghapus data servis.';
                        showToastError(msg);
                    }
                });
            }
        });
    }
</script>
@endpush
