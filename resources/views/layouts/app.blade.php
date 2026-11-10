<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | SI-KDO BMD</title>

    <!-- Font Awesome (Local Asset) -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables (Local Asset) -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 (Local Asset) -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 (Local Asset) -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- Theme style AdminLTE 3 (Local Asset) -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .main-sidebar {
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .brand-link {
            border-bottom: 1px solid #4f5962;
        }
        .brand-image-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            color: #ffc107;
        }
        .badge-baik {
            background-color: #28a745;
            color: #fff;
        }
        .badge-rusak-ringan {
            background-color: #ffc107;
            color: #212529;
        }
        .badge-rusak-berat {
            background-color: #dc3545;
            color: #fff;
        }
        .table th {
            vertical-align: middle;
            background-color: #f8f9fa;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .select2-container--bootstrap4 .select2-selection {
            border-radius: 0.25rem;
        }
        .card-title {
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <span class="nav-link font-weight-bold text-dark">
                    Sistem Informasi Pengelolaan Kendaraan Dinas Operasional (KDO BMD)
                </span>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center mr-2" style="width: 32px; height: 32px;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span class="d-none d-md-inline font-weight-bold">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <i class="fas fa-chevron-down ml-2 small text-muted"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <i class="fas fa-user-circle fa-4x text-white mb-2"></i>
                        <p>
                            {{ Auth::user()->name ?? 'Administrator' }}
                            <small class="text-white-50">{{ Auth::user()->email ?? 'admin@kdo.go.id' }}</small>
                            <small class="badge badge-warning mt-1">Pengelola Aset Daerah</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer d-flex justify-content-between">
                        <a href="{{ route('api-docs') }}" class="btn btn-default btn-flat btn-sm">
                            <i class="fas fa-code mr-1"></i> API Docs
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-flat btn-sm">
                                <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
            <i class="fas fa-truck-monster brand-image-icon ml-3"></i>
            <span class="brand-text font-weight-bold">SI-KDO <span class="text-warning">BMD</span></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-3">
                <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase font-weight-bold text-muted small mt-2">Entitas Utama</li>

                    <li class="nav-item">
                        <a href="{{ route('kdo.index') }}" class="nav-link {{ request()->routeIs('kdo.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-car-side text-primary"></i>
                            <p>
                                Kendaraan Dinas (KDO)
                                <span class="right badge badge-info">Utama</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pns.index') }}" class="nav-link {{ request()->routeIs('pns.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tie text-success"></i>
                            <p>Pegawai (PNS)</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('perangkat-daerah.index') }}" class="nav-link {{ request()->routeIs('perangkat-daerah.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-landmark text-warning"></i>
                            <p>Perangkat Daerah (PD)</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase font-weight-bold text-muted small mt-2">Operasional & Inovasi</li>

                    <li class="nav-item">
                        <a href="{{ route('pemeliharaan.index') }}" class="nav-link {{ request()->routeIs('pemeliharaan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tools text-danger"></i>
                            <p>Riwayat Servis / Kondisi</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print text-teal"></i>
                            <p>Laporan & Cetak BMD</p>
                        </a>
                    </li>

                    <li class="nav-header text-uppercase font-weight-bold text-muted small mt-2">Developer & Dokumentasi</li>

                    <li class="nav-item">
                        <a href="{{ route('api-docs') }}" class="nav-link {{ request()->routeIs('api-docs') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open text-lightblue"></i>
                            <p>Dokumentasi REST API</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-weight-bold text-dark">@yield('page_title', 'Halaman')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Beranda</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid pb-4">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer small">
        <div class="float-right d-none d-sm-block">
            <b>SI-KDO BMD</b> v1.0.0 (Laravel 12 + AdminLTE 3)
        </div>
        <strong>Hak Cipta &copy; {{ date('Y') }} Pemerintah Daerah.</strong> Pengelolaan Barang Milik Daerah.
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS (Local Assets) -->
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
    // Global AJAX setup for Laravel CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    // Helper functions for alerts and notifications
    function showToastSuccess(message) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    }

    function showToastError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: message,
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#dc3545'
        });
    }

    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(amount);
    }

    function getKondisiBadge(kondisi) {
        if (kondisi === 'Baik') {
            return '<span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Baik</span>';
        } else if (kondisi === 'Rusak Ringan') {
            return '<span class="badge badge-warning px-2 py-1"><i class="fas fa-exclamation-circle mr-1"></i> Rusak Ringan</span>';
        } else if (kondisi === 'Rusak Berat') {
            return '<span class="badge badge-danger px-2 py-1"><i class="fas fa-times-circle mr-1"></i> Rusak Berat</span>';
        }
        return '<span class="badge badge-secondary">' + kondisi + '</span>';
    }

    function getStatusPenggunaanBadge(status) {
        if (status === 'Digunakan') {
            return '<span class="badge badge-primary px-2 py-1"><i class="fas fa-user-check mr-1"></i> Digunakan</span>';
        } else if (status === 'Tersedia/Pool') {
            return '<span class="badge badge-info px-2 py-1"><i class="fas fa-warehouse mr-1"></i> Tersedia (Pool)</span>';
        } else if (status === 'Dalam Perbaikan') {
            return '<span class="badge badge-danger px-2 py-1"><i class="fas fa-wrench mr-1"></i> Dalam Perbaikan</span>';
        }
        return '<span class="badge badge-secondary">' + status + '</span>';
    }
</script>
@stack('scripts')
</body>
</html>
