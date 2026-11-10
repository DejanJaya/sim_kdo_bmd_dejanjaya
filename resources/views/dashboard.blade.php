@extends('layouts.app')

@section('title', 'Dashboard Eksekutif')
@section('page_title', 'Dashboard Inventaris KDO BMD')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Row 1: Top Small Boxes (Kondisi Utama KDO) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3 id="stat-total-kdo"><i class="fas fa-spinner fa-spin fa-xs"></i></h3>
                <p class="font-weight-bold mb-0">Total Kendaraan Dinas (KDO)</p>
                <small class="text-white-50">Tercatat dalam BMD</small>
            </div>
            <div class="icon">
                <i class="fas fa-car"></i>
            </div>
            <a href="{{ route('kdo.index') }}" class="small-box-footer">
                Lihat Seluruh Kendaraan <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3 id="stat-kondisi-baik"><i class="fas fa-spinner fa-spin fa-xs"></i></h3>
                <p class="font-weight-bold mb-0">Kondisi Baik</p>
                <small class="text-white-50">Siap Operasional Penuh</small>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('kdo.index') }}?kondisi=Baik" class="small-box-footer">
                Filter Kondisi Baik <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3 id="stat-kondisi-rusak-ringan" class="text-dark"><i class="fas fa-spinner fa-spin fa-xs"></i></h3>
                <p class="font-weight-bold mb-0 text-dark">Kondisi Rusak Ringan</p>
                <small class="text-dark">Perlu Perawatan / Servis</small>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="{{ route('kdo.index') }}?kondisi=Rusak+Ringan" class="small-box-footer text-dark">
                Filter Rusak Ringan <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3 id="stat-kondisi-rusak-berat"><i class="fas fa-spinner fa-spin fa-xs"></i></h3>
                <p class="font-weight-bold mb-0">Kondisi Rusak Berat</p>
                <small class="text-white-50">Perlu Rekomendasi/Lelang</small>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <a href="{{ route('kdo.index') }}?kondisi=Rusak+Berat" class="small-box-footer">
                Filter Rusak Berat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Row 2: Info Boxes Tambahan (PNS, PD, Biaya, Status) -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-user-tie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Penanggung Jawab (PNS)</span>
                <span class="info-box-number h5 mb-0" id="stat-total-pns">-</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-landmark"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Perangkat Daerah (PD)</span>
                <span class="info-box-number h5 mb-0" id="stat-total-pd">-</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-warehouse"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">KDO Tersedia (Pool)</span>
                <span class="info-box-number h5 mb-0" id="stat-status-pool">-</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Total Biaya Servis</span>
                <span class="info-box-number h6 mb-0 text-teal font-weight-bold" id="stat-total-biaya">-</span>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Charts Visualisasi -->
<div class="row">
    <!-- Chart Donat Kondisi KDO -->
    <div class="col-md-5">
        <div class="card card-outline card-primary shadow-sm h-100">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1 text-primary"></i>
                    Proporsi Kondisi Fisik Kendaraan
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-responsive" style="height: 260px; position: relative;">
                    <canvas id="chartKondisi"></canvas>
                </div>
                <div class="d-flex justify-content-around mt-3 small font-weight-bold text-center">
                    <div><i class="fas fa-circle text-success"></i> Baik: <span id="label-baik">0</span></div>
                    <div><i class="fas fa-circle text-warning"></i> Rusak Ringan: <span id="label-rusak-ringan">0</span></div>
                    <div><i class="fas fa-circle text-danger"></i> Rusak Berat: <span id="label-rusak-berat">0</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Bar Distribusi per OPD -->
    <div class="col-md-7">
        <div class="card card-outline card-primary shadow-sm h-100">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar mr-1 text-primary"></i>
                    Distribusi Unit KDO per Perangkat Daerah (PD)
                </h3>
            </div>
            <div class="card-body">
                <div class="chart" style="height: 280px; position: relative;">
                    <canvas id="chartPd"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 4: Pengingat Pajak & Kendaraan Perlu Perhatian -->
<div class="row mt-4">
    <!-- Pengingat Pajak/STNK -->
    <div class="col-md-6">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title text-dark">
                    <i class="fas fa-bell text-warning mr-1"></i>
                    Pengingat Jatuh Tempo Pajak / STNK
                </h3>
                <div class="card-tools">
                    <span class="badge badge-warning text-dark font-weight-normal">Jatuh Tempo Terdekat</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" id="table-pajak">
                        <thead>
                            <tr>
                                <th>No. Polisi</th>
                                <th>Kendaraan</th>
                                <th>Perangkat Daerah</th>
                                <th>Jatuh Tempo</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Memuat data pengingat pajak...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- KDO Rusak & Butuh Tindak Lanjut -->
    <div class="col-md-6">
        <div class="card card-outline card-danger shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-exclamation-triangle text-danger mr-1"></i>
                    Daftar KDO Perlu Perbaikan / Pemeliharaan
                </h3>
                <div class="card-tools">
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-tool text-primary">
                        <i class="fas fa-plus-circle mr-1"></i> Catat Servis
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0" id="table-urgent">
                        <thead>
                            <tr>
                                <th>No. Polisi</th>
                                <th>Tipe / Merk</th>
                                <th>Kondisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    <i class="fas fa-spinner fa-spin mr-1"></i> Memuat data kendaraan rusak...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let donutChartInstance = null;
    let barChartInstance = null;

    $(document).ready(function() {
        loadDashboardData();
    });

    function loadDashboardData() {
        $.ajax({
            url: '/api/dashboard/summary',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    const data = response.data;
                    renderCards(data.cards);
                    renderDonutChart(data.chart_kondisi);
                    renderBarChart(data.chart_pd);
                    renderUpcomingTax(data.upcoming_tax);
                    renderUrgentKdo(data.urgent_kdo);
                }
            },
            error: function(xhr) {
                console.error("Gagal memuat dashboard:", xhr);
                showToastError('Gagal memuat data ringkasan dashboard.');
            }
        });
    }

    function renderCards(cards) {
        $('#stat-total-kdo').text(cards.total_kdo + ' Unit');
        $('#stat-kondisi-baik').text(cards.kondisi_baik + ' Unit');
        $('#stat-kondisi-rusak-ringan').text(cards.kondisi_rusak_ringan + ' Unit');
        $('#stat-kondisi-rusak-berat').text(cards.kondisi_rusak_berat + ' Unit');

        $('#label-baik').text(cards.kondisi_baik);
        $('#label-rusak-ringan').text(cards.kondisi_rusak_ringan);
        $('#label-rusak-berat').text(cards.kondisi_rusak_berat);

        $('#stat-total-pns').text(cards.total_pns + ' Pegawai');
        $('#stat-total-pd').text(cards.total_pd + ' SKPD / OPD');
        $('#stat-status-pool').text(cards.status_pool + ' Unit');
        $('#stat-total-biaya').text(formatRupiah(cards.total_biaya_pemeliharaan));
    }

    function renderDonutChart(chartData) {
        const ctx = document.getElementById('chartKondisi').getContext('2d');
        if (donutChartInstance) {
            donutChartInstance.destroy();
        }

        donutChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartData.labels,
                datasets: [{
                    data: chartData.data,
                    backgroundColor: chartData.colors,
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                cutoutPercentage: 65,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });
    }

    function renderBarChart(pdData) {
        const ctx = document.getElementById('chartPd').getContext('2d');
        if (barChartInstance) {
            barChartInstance.destroy();
        }

        const labels = pdData.map(item => item.label);
        const dataValues = pdData.map(item => item.total);

        barChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah KDO (Unit)',
                    data: dataValues,
                    backgroundColor: '#17a2b8',
                    borderColor: '#117a8b',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        },
                        gridLines: {
                            color: '#e9ecef'
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        });
    }

    function renderUpcomingTax(taxes) {
        const tbody = $('#table-pajak tbody');
        tbody.empty();

        if (!taxes || taxes.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center py-3 text-muted">Tidak ada pengingat pajak dalam waktu dekat.</td></tr>');
            return;
        }

        const today = new Date();

        taxes.forEach(item => {
            const taxDate = new Date(item.tanggal_pajak);
            const diffTime = taxDate - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            let statusBadge = '';
            if (diffDays < 0) {
                statusBadge = '<span class="badge badge-danger">Lewat ' + Math.abs(diffDays) + ' Hari</span>';
            } else if (diffDays <= 14) {
                statusBadge = '<span class="badge badge-warning text-dark">' + diffDays + ' Hari Lagi</span>';
            } else {
                statusBadge = '<span class="badge badge-info">' + diffDays + ' Hari Lagi</span>';
            }

            const formattedDate = taxDate.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            tbody.append(`
                <tr>
                    <td><span class="font-weight-bold text-primary">${item.nomor_polisi}</span></td>
                    <td>${item.merk} ${item.tipe}</td>
                    <td><small class="text-muted">${item.perangkat_daerah ? item.perangkat_daerah.nama_pd : '-'}</small></td>
                    <td>${formattedDate}</td>
                    <td>${statusBadge}</td>
                </tr>
            `);
        });
    }

    function renderUrgentKdo(kdos) {
        const tbody = $('#table-urgent tbody');
        tbody.empty();

        if (!kdos || kdos.length === 0) {
            tbody.append('<tr><td colspan="5" class="text-center py-3 text-muted">Semua kendaraan dalam kondisi baik!</td></tr>');
            return;
        }

        kdos.forEach(item => {
            tbody.append(`
                <tr>
                    <td><span class="font-weight-bold text-dark">${item.nomor_polisi}</span></td>
                    <td>${item.merk} ${item.tipe}</td>
                    <td>${getKondisiBadge(item.kondisi)}</td>
                    <td>${getStatusPenggunaanBadge(item.status_penggunaan)}</td>
                    <td>
                        <a href="{{ route('kdo.index') }}?search=${encodeURIComponent(item.nomor_polisi)}" class="btn btn-xs btn-outline-info">
                            <i class="fas fa-eye mr-1"></i> Detail
                        </a>
                    </td>
                </tr>
            `);
        });
    }
</script>
@endpush
