<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Inventaris KDO BMD - {{ date('d-m-Y') }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #222;
            margin: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header h3 {
            margin: 0;
            font-size: 15px;
            text-transform: uppercase;
        }
        .header h4 {
            margin: 3px 0;
            font-size: 13px;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #555;
        }
        .report-title {
            text-align: center;
            margin-bottom: 12px;
            font-weight: bold;
            font-size: 13px;
            text-transform: uppercase;
        }
        .filter-info {
            margin-bottom: 10px;
            font-size: 11px;
        }
        .table-report {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-report th, .table-report td {
            border: 1px solid #777;
            padding: 5px 6px;
            text-align: left;
        }
        .table-report th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge-kondisi {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 10px;
        }
        .signatures {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-size: 11px;
        }
        .sign-space {
            height: 65px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 7px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Cetak Dokumen / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 7px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h3>PEMERINTAH DAERAH KABUPATEN / KOTA</h3>
        <h4>BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH (BPKAD)</h4>
        <p>BIDANG PENGELOLAAN BARANG MILIK DAERAH (BMD) TAHUN ANGGARAN {{ date('Y') }}</p>
    </div>

    <div class="report-title">
        REKAPITULASI INVENTARIS KENDARAAN DINAS OPERASIONAL (KDO)
    </div>

    <div class="filter-info">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 18%;"><b>Perangkat Daerah:</b></td>
                <td>{{ $pdTerpilih ? ($pdTerpilih->nama_pd . ' (' . $pdTerpilih->kode_pd . ')') : 'Seluruh Perangkat Daerah (OPD)' }}</td>
                <td style="width: 15%; text-align: right;"><b>Tanggal Cetak:</b></td>
                <td style="width: 15%; text-align: right;">{{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td><b>Filter Kondisi:</b></td>
                <td>{{ $request->kondisi ? $request->kondisi : 'Seluruh Kondisi Fisik' }}</td>
                <td style="text-align: right;"><b>Total Unit:</b></td>
                <td style="text-align: right;"><b>{{ $kdos->count() }} Unit</b></td>
            </tr>
        </table>
    </div>

    <table class="table-report">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 11%;">No. Polisi</th>
                <th style="width: 11%;">Kode Barang</th>
                <th style="width: 16%;">Merk & Tipe Kendaraan</th>
                <th style="width: 6%;">Tahun</th>
                <th style="width: 18%;">Perangkat Daerah (SKPD)</th>
                <th style="width: 18%;">Pegawai Penanggung Jawab</th>
                <th style="width: 9%;">Kondisi</th>
                <th style="width: 8%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kdos as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $item->nomor_polisi }}</td>
                    <td><code>{{ $item->kode_barang ?? '-' }}</code></td>
                    <td>
                        <b>{{ $item->merk }}</b> {{ $item->tipe }}<br>
                        <small style="color: #666;">Warna: {{ $item->warna }} ({{ $item->kategori }})</small>
                    </td>
                    <td class="text-center">{{ $item->tahun_produksi }}</td>
                    <td>{{ $item->perangkatDaerah->singkatan ?? $item->perangkatDaerah->nama_pd }}</td>
                    <td>
                        @if($item->pns)
                            <b>{{ $item->pns->nama }}</b><br>
                            <small style="color: #555;">NIP. {{ $item->pns->nip }}</small>
                        @else
                            <i style="color: #777;">Tersedia (Pool)</i>
                        @endif
                    </td>
                    <td class="text-center">
                        <b>{{ $item->kondisi }}</b>
                    </td>
                    <td class="text-center">{{ $item->status_penggunaan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 15px; color: #777;">
                        Tidak ada data kendaraan dinas yang sesuai dengan kriteria filter.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                @if($pdTerpilih)
                    Kepala {{ $pdTerpilih->nama_pd }}
                    <div class="sign-space"></div>
                    <b>{{ $pdTerpilih->nama_kepala ?? '(..........................................)' }}</b><br>
                    NIP. {{ $pdTerpilih->nip_kepala ?? '..........................................' }}
                @else
                    Kepala Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD)
                    <div class="sign-space"></div>
                    <b>Drs. Agus Triyono, M.Si.</b><br>
                    NIP. 19690522 199403 1 005
                @endif
            </td>
            <td>
                {{ date('d F Y') }}<br>
                Pengurus Barang Pengguna / Pengelola BMD
                <div class="sign-space"></div>
                <b>{{ Auth::user()->name ?? 'Administrator BMD' }}</b><br>
                NIP. ..........................................
            </td>
        </tr>
    </table>
</body>
</html>
