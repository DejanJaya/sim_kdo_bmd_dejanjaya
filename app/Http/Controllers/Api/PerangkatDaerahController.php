<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDaerah;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerangkatDaerahController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = PerangkatDaerah::withCount(['pns', 'kdos']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pd', 'like', "%{$search}%")
                  ->orWhere('kode_pd', 'like', "%{$search}%")
                  ->orWhere('singkatan', 'like', "%{$search}%")
                  ->orWhere('nama_kepala', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 50);
        $data = $query->orderBy('nama_pd', 'asc')->paginate($perPage);

        return $this->successResponse($data, 'Daftar perangkat daerah berhasil dimuat.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_pd' => 'required|string|max:50|unique:perangkat_daerahs,kode_pd',
            'nama_pd' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'nama_kepala' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:30',
        ], [
            'kode_pd.required' => 'Kode Perangkat Daerah wajib diisi.',
            'kode_pd.unique' => 'Kode Perangkat Daerah sudah terdaftar.',
            'nama_pd.required' => 'Nama Perangkat Daerah wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $pd = PerangkatDaerah::create($request->all());

        return $this->successResponse($pd, 'Data Perangkat Daerah berhasil ditambahkan.', 201);
    }

    public function show($id): JsonResponse
    {
        $pd = PerangkatDaerah::with(['pns', 'kdos.pns'])->find($id);

        if (!$pd) {
            return $this->errorResponse('Data Perangkat Daerah tidak ditemukan.', 404);
        }

        return $this->successResponse($pd, 'Detail Perangkat Daerah berhasil dimuat.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $pd = PerangkatDaerah::find($id);

        if (!$pd) {
            return $this->errorResponse('Data Perangkat Daerah tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'kode_pd' => 'required|string|max:50|unique:perangkat_daerahs,kode_pd,' . $id,
            'nama_pd' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'nama_kepala' => 'nullable|string|max:255',
            'nip_kepala' => 'nullable|string|max:30',
        ], [
            'kode_pd.required' => 'Kode Perangkat Daerah wajib diisi.',
            'kode_pd.unique' => 'Kode Perangkat Daerah sudah digunakan oleh instansi lain.',
            'nama_pd.required' => 'Nama Perangkat Daerah wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $pd->update($request->all());

        return $this->successResponse($pd, 'Data Perangkat Daerah berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $pd = PerangkatDaerah::withCount(['pns', 'kdos'])->find($id);

        if (!$pd) {
            return $this->errorResponse('Data Perangkat Daerah tidak ditemukan.', 404);
        }

        // Integrity check: prevent deletion if still has PNS or KDO
        if ($pd->pns_count > 0 || $pd->kdos_count > 0) {
            return $this->errorResponse(
                "Tidak dapat menghapus {$pd->nama_pd} karena masih memiliki {$pd->pns_count} pegawai dan {$pd->kdos_count} unit kendaraan terkait.",
                409
            );
        }

        $pd->delete();

        return $this->successResponse(null, 'Data Perangkat Daerah berhasil dihapus.');
    }
}
