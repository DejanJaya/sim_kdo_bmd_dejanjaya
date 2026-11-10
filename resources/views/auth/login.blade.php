@extends('layouts.auth')

@section('title', 'Masuk Sistem')

@section('content')
<div class="login-box">
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header text-center py-4">
            <div class="brand-logo-icon">
                <i class="fas fa-car-side"></i>
            </div>
            <a href="{{ route('login') }}" class="h3 font-weight-bold text-dark d-block mb-1">
                SI-KDO <b>BMD</b>
            </a>
            <small class="text-muted d-block">
                Sistem Informasi Pengelolaan Kendaraan Dinas Operasional<br>
                Barang Milik Daerah (BMD)
            </small>
        </div>
        <div class="card-body login-card-body">
            <p class="login-box-msg text-secondary">Silakan masuk menggunakan akun terdaftar</p>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           placeholder="Alamat Email" value="{{ old('email', 'admin@kdo.go.id') }}" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope text-muted"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Kata Sandi" value="password123" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock text-muted"></span>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember" checked>
                            <label for="remember" class="font-weight-normal text-muted mb-0">
                                Ingat Saya
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                        </button>
                    </div>
                </div>
            </form>

            <div class="p-3 bg-light rounded border mt-3">
                <div class="font-weight-bold text-secondary mb-1">
                    <i class="fas fa-info-circle text-info mr-1"></i> Akun Bawaan (Default):
                </div>
                <div class="small text-muted mb-1">
                    <b>Admin BMD:</b> <code>admin@kdo.go.id</code> / <code>password123</code>
                </div>
                <div class="small text-muted">
                    <b>Operator:</b> <code>operator@kdo.go.id</code> / <code>password123</code>
                </div>
            </div>
        </div>
        <div class="card-footer text-center py-2 bg-white text-muted small">
            &copy; {{ date('Y') }} Pengelolaan Barang Milik Daerah
        </div>
    </div>
</div>
@endsection
