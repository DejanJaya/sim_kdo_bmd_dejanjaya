<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pns;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PnsController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Pns::with(['perangkatDaerah'])->withCount('kdos');

        if ($request->filled('perangkat_daerah_id')) {
            $query->where('perangkat_daerah_id', $request->perangkat_daerah_id);
        }

        if ($request->filled('status_pegawai')) {
            $query->where('status_pegawai', $request->status_pegawai);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('golongan', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 50);
        $data = $query->orderBy('nama', 'asc')->paginate($perPage);

        return $this->successResponse($data, 'Daftar PNS berhasil dimuat.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'perangkat_daerah_id' => 'required|exists:perangkat_daerahs,id',
            'nip' => 'required|string|max:30|unique:pns,nip',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'status_pegawai' => 'required|in:Aktif,Pensiun,Mutasi',
        ], [
            'perangkat_daerah_id.required' => 'Perangkat Daerah wajib dipilih.',
            'perangkat_daerah_id.exists' => 'Perangkat Daerah tidak valid.',
            'nip.required' => 'NIP pegawai wajib diisi.',
            'nip.unique' => 'NIP sudah terdaftar di sistem.',
            'nama.required' => 'Nama lengkap pegawai wajib diisi.',
            'jabatan.required' => 'Jabatan pegawai wajib diisi.',
            'golongan.required' => 'Pangkat/Golongan pegawai wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $pns = Pns::create($request->all());

        return $this->successResponse($pns->load('perangkatDaerah'), 'Data PNS berhasil ditambahkan.', 201);
    }

    public function show($id): JsonResponse
    {
        $pns = Pns::with(['perangkatDaerah', 'kdos', 'riwayatPemegangs.kdo'])->find($id);

        if (!$pns) {
            return $this->errorResponse('Data PNS tidak ditemukan.', 404);
        }

        return $this->successResponse($pns, 'Detail PNS berhasil dimuat.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $pns = Pns::find($id);

        if (!$pns) {
            return $this->errorResponse('Data PNS tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'perangkat_daerah_id' => 'required|exists:perangkat_daerahs,id',
            'nip' => 'required|string|max:30|unique:pns,nip,' . $id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'golongan' => 'required|string|max:50',
            'no_telepon' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'status_pegawai' => 'required|in:Aktif,Pensiun,Mutasi',
        ], [
            'perangkat_daerah_id.required' => 'Perangkat Daerah wajib dipilih.',
            'nip.required' => 'NIP pegawai wajib diisi.',
            'nip.unique' => 'NIP sudah digunakan oleh pegawai lain.',
            'nama.required' => 'Nama lengkap pegawai wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $pns->update($request->all());

        return $this->successResponse($pns->load('perangkatDaerah'), 'Data PNS berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $pns = Pns::withCount('kdos')->find($id);

        if (!$pns) {
            return $this->errorResponse('Data PNS tidak ditemukan.', 404);
        }

        if ($pns->kdos_count > 0) {
            return $this->errorResponse(
                "Tidak dapat menghapus pegawai {$pns->nama} karena masih tercatat sebagai pemegang {$pns->kdos_count} unit kendaraan dinas aktif. Silakan alihkan penanggung jawab terlebih dahulu.",
                409
            );
        }

        $pns->delete();

        return $this->successResponse(null, 'Data PNS berhasil dihapus.');
    }
}
