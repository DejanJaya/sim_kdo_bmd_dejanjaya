<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kartu Inventaris KDO - {{ $kdo->nomor_polisi }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h3 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header h4 {
            margin: 4px 0;
            font-size: 14px;
        }
        .header p {
            margin: 0;
            font-size: 11px;
            color: #555;
        }
        .title-box {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-data th, .table-data td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: left;
        }
        .table-data th {
            background-color: #f2f2f2;
            width: 30%;
        }
        .table-servis {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .table-servis th, .table-servis td {
            border: 1px solid #999;
            padding: 5px;
            text-align: left;
            font-size: 11px;
        }
        .table-servis th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .signatures {
            margin-top: 30px;
            width: 100%;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .sign-space {
            height: 70px;
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
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-print"></i> Cetak Dokumen / Simpan PDF
        </button>
        <button onclick="window.close()" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h3>PEMERINTAH DAERAH KABUPATEN / KOTA</h3>
        <h4>BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH (BPKAD)</h4>
        <p>SISTEM INFORMASI INVENTARISASI BARANG MILIK DAERAH (BMD)</p>
    </div>

    <div class="title-box">
        KARTU IDENTITAS KENDARAAN DINAS OPERASIONAL (KDO)
    </div>

    <table class="table-data">
        <tr>
            <th>Nomor Polisi (Plat Merah)</th>
            <td style="font-weight: bold; font-size: 13px;">{{ $kdo->nomor_polisi }}</td>
        </tr>
        <tr>
            <th>Kode Barang BMD / NUP</th>
            <td>{{ $kdo->kode_barang ?? '-' }}</td>
        </tr>
        <tr>
            <th>Perangkat Daerah Pengguna (SKPD)</th>
            <td><b>{{ $kdo->perangkatDaerah->nama_pd ?? '-' }}</b></td>
        </tr>
        <tr>
            <th>Penanggung Jawab Pemegang (PNS)</th>
            <td>
                @if($kdo->pns)
                    <b>{{ $kdo->pns->nama }}</b> (NIP: {{ $kdo->pns->nip }})<br>
                    Jabatan: {{ $kdo->pns->jabatan }} - Pangkat/Gol: {{ $kdo->pns->golongan }}
                @else
                    <i>Kendaraan Tersedia / Pool Instansi</i>
                @endif
            </td>
        </tr>
        <tr>
            <th>Merk & Tipe Kendaraan</th>
            <td>{{ $kdo->merk }} {{ $kdo->tipe }}</td>
        </tr>
        <tr>
            <th>Kategori / Tahun Pembuatan</th>
            <td>{{ $kdo->kategori }} / Tahun {{ $kdo->tahun_produksi }}</td>
        </tr>
        <tr>
            <th>Warna Kendaraan</th>
            <td>{{ $kdo->warna }}</td>
        </tr>
        <tr>
            <th>Nomor Rangka (Chassis)</th>
            <td><code>{{ $kdo->nomor_rangka ?? '-' }}</code></td>
        </tr>
        <tr>
            <th>Nomor Mesin</th>
            <td><code>{{ $kdo->nomor_mesin ?? '-' }}</code></td>
        </tr>
        <tr>
            <th>Nomor BPKB</th>
            <td><code>{{ $kdo->nomor_bpkb ?? '-' }}</code></td>
        </tr>
        <tr>
            <th>Kondisi Fisik Terkini</th>
            <td style="font-weight: bold;">{{ $kdo->kondisi }}</td>
        </tr>
        <tr>
            <th>Status Penggunaan</th>
            <td>{{ $kdo->status_penggunaan }}</td>
        </tr>
        <tr>
            <th>Masa Berlaku Pajak / STNK</th>
            <td>{{ $kdo->tanggal_pajak ? date('d F Y', strtotime($kdo->tanggal_pajak)) : '-' }}</td>
        </tr>
        <tr>
            <th>Keterangan / Riwayat Fisik</th>
            <td>{{ $kdo->keterangan ?? '-' }}</td>
        </tr>
    </table>

    <div style="font-weight: bold; margin-bottom: 5px;">Ringkasan Riwayat Pemeliharaan & Servis:</div>
    <table class="table-servis">
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 35%;">Jenis Pemeliharaan</th>
                <th style="width: 25%;">Bengkel</th>
                <th style="width: 15%;">Biaya</th>
                <th style="width: 10%;">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kdo->riwayatPemeliharaans as $servis)
                <tr>
                    <td style="text-align: center;">{{ date('d/m/Y', strtotime($servis->tanggal_servis)) }}</td>
                    <td>{{ $servis->jenis_pemeliharaan }}</td>
                    <td>{{ $servis->bengkel_pelaksana ?? '-' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($servis->biaya, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $servis->kondisi_setelah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #777;">Belum ada catatan servis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                Mengetahui,<br>
                Kepala Perangkat Daerah / Pimpinan
                <div class="sign-space"></div>
                <b>{{ $kdo->perangkatDaerah->nama_kepala ?? '(..........................................)' }}</b><br>
                NIP. {{ $kdo->perangkatDaerah->nip_kepala ?? '..........................................' }}
            </td>
            <td>
                {{ date('d F Y') }}<br>
                Pengurus Barang / Pengelola BMD
                <div class="sign-space"></div>
                <b>{{ Auth::user()->name ?? 'Administrator BMD' }}</b><br>
                NIP. ..........................................
            </td>
        </tr>
    </table>
</body>
</html>
