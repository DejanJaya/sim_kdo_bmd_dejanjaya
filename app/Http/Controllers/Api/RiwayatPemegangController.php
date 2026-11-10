<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPemegang;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RiwayatPemegangController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = RiwayatPemegang::with(['kdo', 'pns']);

        if ($request->filled('kdo_id')) {
            $query->where('kdo_id', $request->kdo_id);
        }

        if ($request->filled('pns_id')) {
            $query->where('pns_id', $request->pns_id);
        }

        $perPage = $request->input('per_page', 50);
        $data = $query->orderBy('tanggal_mulai', 'desc')->paginate($perPage);

        return $this->successResponse($data, 'Riwayat penugasan/BAST pemegang berhasil dimuat.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kdo_id' => 'required|exists:kdos,id',
            'pns_id' => 'required|exists:pns,id',
            'nomor_bast' => 'nullable|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_bast' => 'required|in:Aktif,Selesai',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $record = RiwayatPemegang::create($request->all());

        return $this->successResponse($record->load(['kdo', 'pns']), 'Riwayat penugasan/BAST berhasil ditambahkan.', 201);
    }

    public function show($id): JsonResponse
    {
        $record = RiwayatPemegang::with(['kdo', 'pns'])->find($id);

        if (!$record) {
            return $this->errorResponse('Data riwayat penugasan tidak ditemukan.', 404);
        }

        return $this->successResponse($record, 'Detail riwayat penugasan berhasil dimuat.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $record = RiwayatPemegang::find($id);

        if (!$record) {
            return $this->errorResponse('Data riwayat penugasan tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'nomor_bast' => 'nullable|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_bast' => 'required|in:Aktif,Selesai',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $record->update($request->all());

        return $this->successResponse($record->load(['kdo', 'pns']), 'Data riwayat penugasan berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $record = RiwayatPemegang::find($id);

        if (!$record) {
            return $this->errorResponse('Data riwayat penugasan tidak ditemukan.', 404);
        }

        $record->delete();

        return $this->successResponse(null, 'Data riwayat penugasan berhasil dihapus.');
    }
}
