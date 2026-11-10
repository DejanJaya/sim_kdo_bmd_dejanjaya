@extends('layouts.app')

@section('title', 'Laporan Inventaris BMD')
@section('page_title', 'Laporan & Rekapitulasi Inventaris KDO')

@section('breadcrumb')
<li class="breadcrumb-item active">Laporan Inventaris</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card card-outline card-teal shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-filter text-teal mr-1"></i> Parameter Filter Rekapitulasi
                </h3>
            </div>
            <form action="{{ route('laporan.cetak') }}" method="GET" target="_blank">
                <div class="card-body">
                    <p class="text-muted small">
                        Pilih kriteria inventaris kendaraan dinas operasional yang ingin dicetak ke dalam laporan resmi Barang Milik Daerah (BMD).
                    </p>

                    <div class="form-group">
                        <label for="perangkat_daerah_id">Satuan Kerja Perangkat Daerah (SKPD)</label>
                        <select class="form-control select2" id="perangkat_daerah_id" name="perangkat_daerah_id" style="width: 100%;">
                            <option value="">-- Seluruh Perangkat Daerah --</option>
                            @foreach($perangkatDaerahs as $pd)
                                <option value="{{ $pd->id }}">{{ $pd->nama_pd }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kondisi">Kondisi Fisik Kendaraan</label>
                        <select class="form-control" id="kondisi" name="kondisi">
                            <option value="">-- Seluruh Kondisi (Baik, Rusak Ringan, Rusak Berat) --</option>
                            <option value="Baik">Hanya Kondisi Baik</option>
                            <option value="Rusak Ringan">Hanya Rusak Ringan</option>
                            <option value="Rusak Berat">Hanya Rusak Berat (Usul Lelang/Hapus)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status_penggunaan">Status Penggunaan</label>
                        <select class="form-control" id="status_penggunaan" name="status_penggunaan">
                            <option value="">-- Seluruh Status Penggunaan --</option>
                            <option value="Digunakan">Digunakan</option>
                            <option value="Tersedia/Pool">Tersedia (Pool)</option>
                            <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori Kendaraan</label>
                        <select class="form-control" id="kategori" name="kategori">
                            <option value="">-- Seluruh Kategori --</option>
                            <option value="Roda 4">Roda 4 (Mobil Dinas/Operasional)</option>
                            <option value="Roda 2">Roda 2 (Sepeda Motor)</option>
                            <option value="Roda 6">Roda 6 (Truk/Bus)</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer bg-light d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-teal text-white font-weight-bold">
                        <i class="fas fa-print mr-1"></i> Buka Tampilan Cetak / PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card card-outline card-info shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-info-circle text-info mr-1"></i> Petunjuk & Standar Pelaporan BMD
                </h3>
            </div>
            <div class="card-body">
                <h5>Format Laporan Resmi:</h5>
                <p class="text-muted">
                    Laporan inventarisasi KDO disusun sesuai dengan format standar pengelolaan Barang Milik Daerah (BMD) yang memuat identitas kode barang, spesifikasi fisik kendaraan, legalitas nomor rangka & mesin, kondisi fisik terkini, serta nama dan NIP penanggung jawab pemegang kendaraan.
                </p>

                <div class="callout callout-warning">
                    <h6 class="font-weight-bold">Kegunaan Dokumen:</h6>
                    <ul class="mb-0 pl-3 small text-muted">
                        <li>Lampiran Laporan Keuangan Pemerintah Daerah (LKPD) Bagian Aset Tetap.</li>
                        <li>Verifikasi fisik tahunan (Stock Opname) kendaraan dinas oleh Inspektorat Daerah / BPKAD.</li>
                        <li>Dasar usulan penganggaran pemeliharaan rutin, perbaikan berat, atau lelang penghapusan aset daerah.</li>
                    </ul>
                </div>

                <div class="d-flex justify-content-around mt-4 p-3 bg-light rounded text-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">Lengkap</h4>
                        <small class="text-muted">No. Polisi, Merk, Tipe, NUP</small>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-success mb-0">Akuntabel</h4>
                        <small class="text-muted">Nama & NIP PNS Pemegang</small>
                    </div>
                    <div>
                        <h4 class="font-weight-bold text-danger mb-0">Real-time</h4>
                        <small class="text-muted">Status Kondisi Terkini</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });

    function resetForm() {
        $('#perangkat_daerah_id').val('').trigger('change');
        $('#kondisi').val('');
        $('#status_penggunaan').val('');
        $('#kategori').val('');
    }
</script>
@endpush
