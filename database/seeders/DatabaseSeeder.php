<?php

namespace Database\Seeders;

use App\Models\Kdo;
use App\Models\PerangkatDaerah;
use App\Models\Pns;
use App\Models\RiwayatPemegang;
use App\Models\RiwayatPemeliharaan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with real, comprehensive data.
     */
    public function run(): void
    {
        // 1. User Administrator Sistem KDO BMD
        User::firstOrCreate(
            ['email' => 'admin@kdo.go.id'],
            [
                'name' => 'Administrator BMD',
                'password' => Hash::make('password123'),
            ]
        );

        User::firstOrCreate(
            ['email' => 'operator@kdo.go.id'],
            [
                'name' => 'Operator Aset Daerah',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Data Riil Perangkat Daerah (PD)
        $disdik = PerangkatDaerah::create([
            'kode_pd' => '1.01.0.00.0.00.01.0000',
            'nama_pd' => 'Dinas Pendidikan',
            'singkatan' => 'Disdik',
            'alamat' => 'Jl. Pemuda No. 45, Kompleks Perkantoran Pemerintah Daerah',
            'telepon' => '(021) 8765432',
            'nama_kepala' => 'Dr. H. Bambang Suherman, M.Pd.',
            'nip_kepala' => '19680315 199303 1 004',
        ]);

        $dinkes = PerangkatDaerah::create([
            'kode_pd' => '1.02.0.00.0.00.01.0000',
            'nama_pd' => 'Dinas Kesehatan',
            'singkatan' => 'Dinkes',
            'alamat' => 'Jl. Kesehatan Raya No. 12, Lingkar Barat',
            'telepon' => '(021) 8761234',
            'nama_kepala' => 'dr. Hj. Siti Rahmawati, M.Kes.',
            'nip_kepala' => '19720719 200003 2 003',
        ]);

        $pupr = PerangkatDaerah::create([
            'kode_pd' => '1.03.0.00.0.00.01.0000',
            'nama_pd' => 'Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)',
            'singkatan' => 'Dinas PUPR',
            'alamat' => 'Jl. Jenderal Sudirman No. 88, Zona Pelayanan Terpadu',
            'telepon' => '(021) 8769876',
            'nama_kepala' => 'Ir. Hendra Gunawan, M.T.',
            'nip_kepala' => '19701108 199603 1 002',
        ]);

        $bpkad = PerangkatDaerah::create([
            'kode_pd' => '5.02.0.00.0.00.01.0000',
            'nama_pd' => 'Badan Pengelolaan Keuangan dan Aset Daerah',
            'singkatan' => 'BPKAD',
            'alamat' => 'Gedung A Lantai 3, Kantor Pusat Pemkab',
            'telepon' => '(021) 8762233',
            'nama_kepala' => 'Drs. Agus Triyono, M.Si.',
            'nip_kepala' => '19690522 199403 1 005',
        ]);

        $dishub = PerangkatDaerah::create([
            'kode_pd' => '2.15.0.00.0.00.01.0000',
            'nama_pd' => 'Dinas Perhubungan',
            'singkatan' => 'Dishub',
            'alamat' => 'Jl. Terminal Baru No. 10',
            'telepon' => '(021) 8764455',
            'nama_kepala' => 'Rahmat Hidayat, S.STP., M.M.',
            'nip_kepala' => '19750914 199912 1 001',
        ]);

        // 3. Data Riil Pegawai Negeri Sipil (PNS)
        $pnsList = [
            // Disdik
            [
                'perangkat_daerah_id' => $disdik->id,
                'nip' => '19680315 199303 1 004',
                'nama' => 'Dr. H. Bambang Suherman, M.Pd.',
                'jabatan' => 'Kepala Dinas Pendidikan',
                'golongan' => 'Pembina Utama Muda (IV/c)',
                'no_telepon' => '081289123456',
                'email' => 'bambang.disdik@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $disdik->id,
                'nip' => '19770821 200212 1 002',
                'nama' => 'Dedi Suryadi, S.Pd., M.Si.',
                'jabatan' => 'Sekretaris Dinas Pendidikan',
                'golongan' => 'Pembina (IV/a)',
                'no_telepon' => '081311223344',
                'email' => 'dedi.suryadi@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $disdik->id,
                'nip' => '19850410 200902 2 006',
                'nama' => 'Nurul Hidayati, S.E.',
                'jabatan' => 'Pengurus Barang Pengguna (BMD)',
                'golongan' => 'Penata (III/c)',
                'no_telepon' => '085712345678',
                'email' => 'nurul.asetdisdik@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],

            // Dinkes
            [
                'perangkat_daerah_id' => $dinkes->id,
                'nip' => '19720719 200003 2 003',
                'nama' => 'dr. Hj. Siti Rahmawati, M.Kes.',
                'jabatan' => 'Kepala Dinas Kesehatan',
                'golongan' => 'Pembina Utama Muda (IV/c)',
                'no_telepon' => '081198765432',
                'email' => 'siti.rahmawati@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $dinkes->id,
                'nip' => '19810115 200604 1 008',
                'nama' => 'dr. Ahmad Fauzi, Sp.A.',
                'jabatan' => 'Kepala Bidang Pelayanan Kesehatan',
                'golongan' => 'Pembina (IV/a)',
                'no_telepon' => '081298445566',
                'email' => 'ahmad.fauzi@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $dinkes->id,
                'nip' => '19890612 201101 2 015',
                'nama' => 'Dewi Sartika, S.Kep., Ners.',
                'jabatan' => 'Koordinator Tim Survailans Puskesmas',
                'golongan' => 'Penata Muda Tk. I (III/b)',
                'no_telepon' => '087855667788',
                'email' => 'dewi.sartika@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],

            // PUPR
            [
                'perangkat_daerah_id' => $pupr->id,
                'nip' => '19701108 199603 1 002',
                'nama' => 'Ir. Hendra Gunawan, M.T.',
                'jabatan' => 'Kepala Dinas PUPR',
                'golongan' => 'Pembina Utama Madya (IV/d)',
                'no_telepon' => '081233445566',
                'email' => 'hendra.pupr@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $pupr->id,
                'nip' => '19820325 200801 1 011',
                'nama' => 'Bayu Wicaksono, S.T., M.Eng.',
                'jabatan' => 'Kepala Bidang Bina Marga',
                'golongan' => 'Penata Tingkat I (III/d)',
                'no_telepon' => '081399887766',
                'email' => 'bayu.binamarga@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $pupr->id,
                'nip' => '19900918 201402 1 003',
                'nama' => 'Eko Prasetyo, A.Md.',
                'jabatan' => 'Teknisi Pengawas Proyek Lapangan',
                'golongan' => 'Pengatur (II/c)',
                'no_telepon' => '085611223344',
                'email' => 'eko.prasetyo@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],

            // BPKAD & Dishub
            [
                'perangkat_daerah_id' => $bpkad->id,
                'nip' => '19690522 199403 1 005',
                'nama' => 'Drs. Agus Triyono, M.Si.',
                'jabatan' => 'Kepala BPKAD',
                'golongan' => 'Pembina Utama Muda (IV/c)',
                'no_telepon' => '081122334455',
                'email' => 'agus.triyono@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
            [
                'perangkat_daerah_id' => $dishub->id,
                'nip' => '19750914 199912 1 001',
                'nama' => 'Rahmat Hidayat, S.STP., M.M.',
                'jabatan' => 'Kepala Dinas Perhubungan',
                'golongan' => 'Pembina Tingkat I (IV/b)',
                'no_telepon' => '081255667788',
                'email' => 'rahmat.dishub@pemda.go.id',
                'status_pegawai' => 'Aktif',
            ],
        ];

        $pnsModels = [];
        foreach ($pnsList as $item) {
            $pnsModels[$item['nip']] = Pns::create($item);
        }

        // 4. Data Riil Kendaraan Dinas Operasional (KDO)
        $kdos = [
            // KDO 1: Innova Kadisdik
            [
                'perangkat_daerah_id' => $disdik->id,
                'pns_id' => $pnsModels['19680315 199303 1 004']->id,
                'nomor_polisi' => 'B 1001 PQD',
                'kode_barang' => '02.03.01.01.001',
                'merk' => 'Toyota',
                'tipe' => 'Kijang Innova 2.0 V A/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2022,
                'warna' => 'Hitam Metalik',
                'nomor_rangka' => 'MHF11GB40K0012398',
                'nomor_mesin' => '1TR-FE-7892341',
                'nomor_bpkb' => 'N-04581298',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-12-15',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas operasional Kepala Dinas Pendidikan. Kondisi mesin terawat, servis berkala di bengkel resmi.',
            ],
            // KDO 2: Avanza Sekdisdik
            [
                'perangkat_daerah_id' => $disdik->id,
                'pns_id' => $pnsModels['19770821 200212 1 002']->id,
                'nomor_polisi' => 'B 1024 PQD',
                'kode_barang' => '02.03.01.01.002',
                'merk' => 'Toyota',
                'tipe' => 'Avanza 1.3 G M/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2021,
                'warna' => 'Silver Metalik',
                'nomor_rangka' => 'MHKM1BA3JK0098451',
                'nomor_mesin' => '1NR-VE-4458912',
                'nomor_bpkb' => 'M-07891244',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-11-20',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas Sekretaris Disdik. AC dingin, ban depan baru diganti.',
            ],
            // KDO 3: Isuzu Panther Disdik (Rusak Berat)
            [
                'perangkat_daerah_id' => $disdik->id,
                'pns_id' => null,
                'nomor_polisi' => 'B 1876 PQD',
                'kode_barang' => '02.03.01.01.003',
                'merk' => 'Isuzu',
                'tipe' => 'Panther Grand Touring 2.5',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2016,
                'warna' => 'Abu-abu Tua Metalik',
                'nomor_rangka' => 'MHCTBR54F0033129',
                'nomor_mesin' => '4JA1-L-8891024',
                'nomor_bpkb' => 'K-01298451',
                'kondisi' => 'Rusak Berat',
                'status_penggunaan' => 'Dalam Perbaikan',
                'tanggal_pajak' => '2025-08-10',
                'foto' => null,
                'keterangan' => 'Mobil pool dinas pendidikan. Mengalami kerusakan pada sistem transmisi dan turun mesin, diusulkan untuk lelang BMD.',
            ],
            // KDO 4: Motor Operasional BMD Disdik
            [
                'perangkat_daerah_id' => $disdik->id,
                'pns_id' => $pnsModels['19850410 200902 2 006']->id,
                'nomor_polisi' => 'B 3450 PQD',
                'kode_barang' => '02.03.01.02.001',
                'merk' => 'Honda',
                'tipe' => 'Vario 125 CBS',
                'kategori' => 'Roda 2',
                'tahun_produksi' => 2021,
                'warna' => 'Merah Hitam',
                'nomor_rangka' => 'MH1JM3114KK091243',
                'nomor_mesin' => 'JM31E-1456789',
                'nomor_bpkb' => 'N-09871234',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2027-01-18',
                'foto' => null,
                'keterangan' => 'Kendaraan roda dua operasional kurir pengantaran berkas dinas.',
            ],

            // KDO 5: CR-V Kadinkes
            [
                'perangkat_daerah_id' => $dinkes->id,
                'pns_id' => $pnsModels['19720719 200003 2 003']->id,
                'nomor_polisi' => 'B 1002 PQD',
                'kode_barang' => '02.03.01.01.004',
                'merk' => 'Honda',
                'tipe' => 'CR-V 1.5 Turbo Prestige',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2023,
                'warna' => 'Putih Mutiara',
                'nomor_rangka' => 'MHRRW1880NJ004561',
                'nomor_mesin' => 'L15BE-9912045',
                'nomor_bpkb' => 'P-03341982',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2027-03-12',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas jabatan Kepala Dinas Kesehatan. Kondisi sangat prima.',
            ],
            // KDO 6: Hilux Single Cab Dinkes (Rusak Ringan)
            [
                'perangkat_daerah_id' => $dinkes->id,
                'pns_id' => $pnsModels['19810115 200604 1 008']->id,
                'nomor_polisi' => 'B 1419 PQD',
                'kode_barang' => '02.03.01.01.005',
                'merk' => 'Toyota',
                'tipe' => 'Hilux 2.4 Single Cabin 4x2',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2019,
                'warna' => 'Putih',
                'nomor_rangka' => 'MR0KB3CD2J0018742',
                'nomor_mesin' => '2GD-FTV-8941023',
                'nomor_bpkb' => 'L-08971266',
                'kondisi' => 'Rusak Ringan',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-11-28',
                'foto' => null,
                'keterangan' => 'Digunakan untuk distribusi obat dan logistik puskesmas. Ada lecet bemper depan kanan dan kampas rem menipis.',
            ],
            // KDO 7: Terios Tim Puskesmas
            [
                'perangkat_daerah_id' => $dinkes->id,
                'pns_id' => $pnsModels['19890612 201101 2 015']->id,
                'nomor_polisi' => 'B 1655 PQD',
                'kode_barang' => '02.03.01.01.006',
                'merk' => 'Daihatsu',
                'tipe' => 'Terios 1.5 R Deluxe A/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2020,
                'warna' => 'Bronze Metalik',
                'nomor_rangka' => 'MHKF8EA2JK0041289',
                'nomor_mesin' => '2NR-VE-6671249',
                'nomor_bpkb' => 'M-05128941',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-12-05',
                'foto' => null,
                'keterangan' => 'Kendaraan lapangan surveilans imunisasi dan penanganan stunting dinas kesehatan.',
            ],

            // KDO 8: Fortuner Kadis PUPR
            [
                'perangkat_daerah_id' => $pupr->id,
                'pns_id' => $pnsModels['19701108 199603 1 002']->id,
                'nomor_polisi' => 'B 1003 PQD',
                'kode_barang' => '02.03.01.01.007',
                'merk' => 'Toyota',
                'tipe' => 'Fortuner 2.8 VRZ 4x4 A/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2022,
                'warna' => 'Hitam Metalik',
                'nomor_rangka' => 'MHF11GB50M0019283',
                'nomor_mesin' => '1GD-FTV-9012348',
                'nomor_bpkb' => 'N-09918234',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2027-02-14',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas jabatan Kepala Dinas PUPR. Rutin meninjau medan proyek jalan dan jembatan.',
            ],
            // KDO 9: Mitsubishi Triton Double Cabin Bina Marga
            [
                'perangkat_daerah_id' => $pupr->id,
                'pns_id' => $pnsModels['19820325 200801 1 011']->id,
                'nomor_polisi' => 'B 1789 PQD',
                'kode_barang' => '02.03.01.01.008',
                'merk' => 'Mitsubishi',
                'tipe' => 'Strada Triton 2.4 Ultimate 4x4',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2020,
                'warna' => 'Silver Metalik',
                'nomor_rangka' => 'MMBJJKL30LH004128',
                'nomor_mesin' => '4N15-UC-8912401',
                'nomor_bpkb' => 'M-06612984',
                'kondisi' => 'Rusak Ringan',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-11-15',
                'foto' => null,
                'keterangan' => 'Kendaraan patroli dan survei kondisi infrastruktur jalan. Suspensi belakang berbunyi dan butuh ganti shock absorber.',
            ],
            // KDO 10: Truk Dump PUPR (Roda 6)
            [
                'perangkat_daerah_id' => $pupr->id,
                'pns_id' => $pnsModels['19900918 201402 1 003']->id,
                'nomor_polisi' => 'B 9234 PQD',
                'kode_barang' => '02.03.01.03.001',
                'merk' => 'Hino',
                'tipe' => 'Dutro 130 HD Dump Truck',
                'kategori' => 'Roda 6',
                'tahun_produksi' => 2018,
                'warna' => 'Hijau Muda',
                'nomor_rangka' => 'MJEC17610J0081249',
                'nomor_mesin' => 'W04D-TM-1289451',
                'nomor_bpkb' => 'L-01824791',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2027-04-20',
                'foto' => null,
                'keterangan' => 'Truk pengangkut material aspal dan batu untuk perbaikan jalan darurat.',
            ],

            // KDO 11: Innova Reborn BPKAD
            [
                'perangkat_daerah_id' => $bpkad->id,
                'pns_id' => $pnsModels['19690522 199403 1 005']->id,
                'nomor_polisi' => 'B 1005 PQD',
                'kode_barang' => '02.03.01.01.009',
                'merk' => 'Toyota',
                'tipe' => 'Kijang Innova 2.4 G Diesel M/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2021,
                'warna' => 'Abu-abu Metalik',
                'nomor_rangka' => 'MHF11GB40K0099412',
                'nomor_mesin' => '2GD-FTV-1123490',
                'nomor_bpkb' => 'M-09124458',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2026-12-29',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas Kepala BPKAD. Pengelolaan aset dan anggaran daerah.',
            ],

            // KDO 12: Motor Patroli Dishub
            [
                'perangkat_daerah_id' => $dishub->id,
                'pns_id' => $pnsModels['19750914 199912 1 001']->id,
                'nomor_polisi' => 'B 3012 PQD',
                'kode_barang' => '02.03.01.02.002',
                'merk' => 'Yamaha',
                'tipe' => 'NMAX 155 Connected ABS',
                'kategori' => 'Roda 2',
                'tahun_produksi' => 2022,
                'warna' => 'Putih Biru (Patroli Dishub)',
                'nomor_rangka' => 'MH3SG5620NJ009124',
                'nomor_mesin' => 'G3L8E-0192841',
                'nomor_bpkb' => 'N-05189241',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Digunakan',
                'tanggal_pajak' => '2027-05-10',
                'foto' => null,
                'keterangan' => 'Kendaraan dinas pengawalan dan patroli rekayasa lalu lintas Dishub.',
            ],

            // KDO 13: Pool Cadangan Mobil Pemda (Tersedia/Pool)
            [
                'perangkat_daerah_id' => $bpkad->id,
                'pns_id' => null,
                'nomor_polisi' => 'B 1099 PQD',
                'kode_barang' => '02.03.01.01.010',
                'merk' => 'Toyota',
                'tipe' => 'Avanza 1.5 Veloz A/T',
                'kategori' => 'Roda 4',
                'tahun_produksi' => 2022,
                'warna' => 'Hitam',
                'nomor_rangka' => 'MHKM1BA3JK0011894',
                'nomor_mesin' => '2NR-VE-9912341',
                'nomor_bpkb' => 'N-01824901',
                'kondisi' => 'Baik',
                'status_penggunaan' => 'Tersedia/Pool',
                'tanggal_pajak' => '2026-11-18',
                'foto' => null,
                'keterangan' => 'Mobil pool BPKAD tersedia untuk tamu kementerian atau penugasan luar kota mendadak.',
            ],
        ];

        $kdoModels = [];
        foreach ($kdos as $item) {
            $kdoModel = Kdo::create($item);
            $kdoModels[$item['nomor_polisi']] = $kdoModel;

            // Jika KDO memiliki pemegang PNS, buat Riwayat BAST Awal
            if (!empty($item['pns_id'])) {
                RiwayatPemegang::create([
                    'kdo_id' => $kdoModel->id,
                    'pns_id' => $item['pns_id'],
                    'nomor_bast' => '028/' . rand(100, 999) . '/BAST-KDO/' . date('Y'),
                    'tanggal_mulai' => date('Y-m-d', strtotime('-' . rand(6, 24) . ' months')),
                    'tanggal_selesai' => null,
                    'status_bast' => 'Aktif',
                    'catatan' => 'Penyerahan kendaraan dinas operasional dalam keadaan bersih, lengkap STNK dan kunci cadangan.',
                ]);
            }
        }

        // 5. Data Riil Riwayat Pemeliharaan & Servis
        $maintenances = [
            [
                'kdo_id' => $kdoModels['B 1001 PQD']->id,
                'tanggal_servis' => '2026-09-15',
                'jenis_pemeliharaan' => 'Servis Berkala 40.000 KM & Ganti Oli Mesin',
                'bengkel_pelaksana' => 'Bengkel Resmi Toyota Auto2000 Juanda',
                'biaya' => 2450000.00,
                'kondisi_sebelum' => 'Baik',
                'kondisi_setelah' => 'Baik',
                'deskripsi' => 'Penggantian oli mesin TMO Synthetic 5W-30, filter oli, filter AC kabin, kuras minyak rem, dan tune-up.',
            ],
            [
                'kdo_id' => $kdoModels['B 1024 PQD']->id,
                'tanggal_servis' => '2026-08-20',
                'jenis_pemeliharaan' => 'Penggantian 2 Buah Ban Depan & Spooring Balancing',
                'bengkel_pelaksana' => 'Toko Ban Bridgestone Pro-Tire Sentra',
                'biaya' => 1850000.00,
                'kondisi_sebelum' => 'Rusak Ringan',
                'kondisi_setelah' => 'Baik',
                'deskripsi' => 'Ban depan sudah aus tipis, diganti dengan Bridgestone Ecopia 185/65 R15 + wheel alignment 4 roda.',
            ],
            [
                'kdo_id' => $kdoModels['B 1876 PQD']->id,
                'tanggal_servis' => '2026-06-10',
                'jenis_pemeliharaan' => 'Diagnosa Transmisi & Kompresi Mesin Lemah',
                'bengkel_pelaksana' => 'Bengkel Diesel Berkah Jaya Motor',
                'biaya' => 750000.00,
                'kondisi_sebelum' => 'Rusak Berat',
                'kondisi_setelah' => 'Rusak Berat',
                'deskripsi' => 'Ditemukan blok silinder retak rambut dan transmisi selip parah. Estimasi perbaikan besar Rp 28.000.000, direkomendasikan penghapusan aset.',
            ],
            [
                'kdo_id' => $kdoModels['B 1419 PQD']->id,
                'tanggal_servis' => '2026-10-02',
                'jenis_pemeliharaan' => 'Perbaikan Sistem Pengereman & Ganti Kampas Rem',
                'bengkel_pelaksana' => 'Bengkel Mobil Utama Mandiri',
                'biaya' => 1250000.00,
                'kondisi_sebelum' => 'Rusak Ringan',
                'kondisi_setelah' => 'Rusak Ringan',
                'deskripsi' => 'Ganti kampas rem depan Bendix dan bubut piringan cakram. Bemper depan masih menunggu antrean klaim asuransi perbaikan bodi.',
            ],
            [
                'kdo_id' => $kdoModels['B 1789 PQD']->id,
                'tanggal_servis' => '2026-07-25',
                'jenis_pemeliharaan' => 'Servis Berkala & Penggantian Filter Solar Solar Double Cabin',
                'bengkel_pelaksana' => 'Dealer Resmi Mitsubishi Srikandi Motors',
                'biaya' => 3100000.00,
                'kondisi_sebelum' => 'Baik',
                'kondisi_setelah' => 'Rusak Ringan',
                'deskripsi' => 'Ganti oli mesin gardan 4x4 dan filter solar. Teknisi mencatat karet bushing per daun belakang getas.',
            ],
            [
                'kdo_id' => $kdoModels['B 9234 PQD']->id,
                'tanggal_servis' => '2026-05-18',
                'jenis_pemeliharaan' => 'Servis Pompa Hidrolik Dump & Ganti Oli Transmisi',
                'bengkel_pelaksana' => 'Bengkel Truk Armada Raya Hino',
                'biaya' => 4500000.00,
                'kondisi_sebelum' => 'Rusak Ringan',
                'kondisi_setelah' => 'Baik',
                'deskripsi' => 'Sil silinder hidrolik dump bocor, diganti kit seal baru dan pengisian fluida hidrolik ISO VG 46.',
            ],
        ];

        foreach ($maintenances as $m) {
            RiwayatPemeliharaan::create($m);
        }
    }
}
