<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kdo;
use App\Models\PerangkatDaerah;
use App\Models\Pns;
use App\Models\RiwayatPemeliharaan;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function summary(): JsonResponse
    {
        $totalKdo = Kdo::count();
        $kondisiBaik = Kdo::where('kondisi', 'Baik')->count();
        $kondisiRusakRingan = Kdo::where('kondisi', 'Rusak Ringan')->count();
        $kondisiRusakBerat = Kdo::where('kondisi', 'Rusak Berat')->count();

        $statusDigunakan = Kdo::where('status_penggunaan', 'Digunakan')->count();
        $statusPool = Kdo::where('status_penggunaan', 'Tersedia/Pool')->count();
        $statusPerbaikan = Kdo::where('status_penggunaan', 'Dalam Perbaikan')->count();

        $totalPns = Pns::count();
        $totalPd = PerangkatDaerah::count();

        // KDO per Perangkat Daerah (untuk Bar/Pie Chart)
        $kdoPerPd = PerangkatDaerah::withCount('kdos')
            ->orderBy('kdos_count', 'desc')
            ->get(['id', 'nama_pd', 'singkatan'])
            ->map(function ($pd) {
                return [
                    'id' => $pd->id,
                    'label' => $pd->singkatan ?: $pd->nama_pd,
                    'nama_lengkap' => $pd->nama_pd,
                    'total' => $pd->kdos_count,
                ];
            });

        // Distribusi Kategori Kendaraan
        $kategoriDistribution = Kdo::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->get();

        // Total Biaya Pemeliharaan
        $totalBiayaServis = RiwayatPemeliharaan::sum('biaya');

        // Pengingat Jatuh Tempo Pajak (dalam 60 hari ke depan atau lewat)
        $upcomingTax = Kdo::with(['perangkatDaerah', 'pns'])
            ->whereNotNull('tanggal_pajak')
            ->where('tanggal_pajak', '<=', Carbon::now()->addDays(60))
            ->orderBy('tanggal_pajak', 'asc')
            ->limit(10)
            ->get();

        // KDO Rusak (Perlu Perhatian)
        $urgentKdo = Kdo::with(['perangkatDaerah', 'pns'])
            ->whereIn('kondisi', ['Rusak Ringan', 'Rusak Berat'])
            ->orderByRaw("FIELD(kondisi, 'Rusak Berat', 'Rusak Ringan')")
            ->limit(10)
            ->get();

        // Aktivitas Pemeliharaan Terbaru
        $recentMaintenance = RiwayatPemeliharaan::with('kdo')
            ->orderBy('tanggal_servis', 'desc')
            ->limit(5)
            ->get();

        return $this->successResponse([
            'cards' => [
                'total_kdo' => $totalKdo,
                'kondisi_baik' => $kondisiBaik,
                'kondisi_rusak_ringan' => $kondisiRusakRingan,
                'kondisi_rusak_berat' => $kondisiRusakBerat,
                'status_digunakan' => $statusDigunakan,
                'status_pool' => $statusPool,
                'status_perbaikan' => $statusPerbaikan,
                'total_pns' => $totalPns,
                'total_pd' => $totalPd,
                'total_biaya_pemeliharaan' => (float)$totalBiayaServis,
            ],
            'chart_kondisi' => [
                'labels' => ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                'data' => [$kondisiBaik, $kondisiRusakRingan, $kondisiRusakBerat],
                'colors' => ['#28a745', '#ffc107', '#dc3545'],
            ],
            'chart_pd' => $kdoPerPd,
            'chart_kategori' => $kategoriDistribution,
            'upcoming_tax' => $upcomingTax,
            'urgent_kdo' => $urgentKdo,
            'recent_maintenance' => $recentMaintenance,
        ], 'Data ringkasan dashboard berhasil dimuat.');
    }
}
