<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kdo;
use App\Models\PerangkatDaerah;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    use ApiResponse;

    /**
     * Endpoint API Rekapitulasi Laporan Inventaris BMD
     */
    public function rekapitulasi(Request $request): JsonResponse
    {
        $query = Kdo::with(['perangkatDaerah', 'pns']);

        if ($request->filled('perangkat_daerah_id')) {
            $query->where('perangkat_daerah_id', $request->perangkat_daerah_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status_penggunaan')) {
            $query->where('status_penggunaan', $request->status_penggunaan);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $kdos = $query->orderBy('nomor_polisi')->get();

        $pd = $request->filled('perangkat_daerah_id')
            ? PerangkatDaerah::find($request->perangkat_daerah_id)
            : null;

        $summary = [
            'total_unit' => $kdos->count(),
            'kondisi_baik' => $kdos->where('kondisi', 'Baik')->count(),
            'kondisi_rusak_ringan' => $kdos->where('kondisi', 'Rusak Ringan')->count(),
            'kondisi_rusak_berat' => $kdos->where('kondisi', 'Rusak Berat')->count(),
            'perangkat_daerah_terpilih' => $pd ? [
                'id' => $pd->id,
                'kode_pd' => $pd->kode_pd,
                'nama_pd' => $pd->nama_pd,
                'nama_kepala' => $pd->nama_kepala,
                'nip_kepala' => $pd->nip_kepala,
            ] : 'Seluruh Perangkat Daerah (OPD)',
            'filter_diterapkan' => [
                'kondisi' => $request->kondisi ?: 'Semua Kondisi',
                'status_penggunaan' => $request->status_penggunaan ?: 'Semua Status',
                'kategori' => $request->kategori ?: 'Semua Kategori',
            ],
            'items' => $kdos,
        ];

        return $this->successResponse($summary, 'Data rekapitulasi inventaris KDO BMD berhasil dimuat.');
    }
}
