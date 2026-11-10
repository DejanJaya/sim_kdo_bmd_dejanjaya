<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kdo;
use App\Models\RiwayatPemeliharaan;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RiwayatPemeliharaanController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = RiwayatPemeliharaan::with(['kdo.perangkatDaerah']);

        if ($request->filled('kdo_id')) {
            $query->where('kdo_id', $request->kdo_id);
        }

        $perPage = $request->input('per_page', 50);
        $data = $query->orderBy('tanggal_servis', 'desc')->paginate($perPage);

        return $this->successResponse($data, 'Riwayat pemeliharaan berhasil dimuat.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'kdo_id' => 'required|exists:kdos,id',
            'tanggal_servis' => 'required|date',
            'jenis_pemeliharaan' => 'required|string|max:255',
            'bengkel_pelaksana' => 'nullable|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'kondisi_sebelum' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'kondisi_setelah' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'deskripsi' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
            'update_kdo_kondisi' => 'nullable|boolean',
        ], [
            'kdo_id.required' => 'Kendaraan dinas wajib dipilih.',
            'tanggal_servis.required' => 'Tanggal pemeliharaan wajib diisi.',
            'jenis_pemeliharaan.required' => 'Jenis pemeliharaan wajib diisi.',
            'biaya.required' => 'Biaya pemeliharaan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $data = $request->except(['bukti_dokumen', 'update_kdo_kondisi']);

        if ($request->hasFile('bukti_dokumen')) {
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('maintenance_docs', 'public');
        }

        $maintenance = RiwayatPemeliharaan::create($data);

        // Secara default, otomatis perbarui kondisi terkini KDO sesuai kondisi_setelah
        $kdo = Kdo::find($request->kdo_id);
        if ($kdo && ($request->boolean('update_kdo_kondisi', true))) {
            $kdo->kondisi = $request->kondisi_setelah;
            if ($request->kondisi_setelah === 'Baik' && $kdo->status_penggunaan === 'Dalam Perbaikan') {
                $kdo->status_penggunaan = $kdo->pns_id ? 'Digunakan' : 'Tersedia/Pool';
            } elseif ($request->kondisi_setelah === 'Rusak Berat') {
                $kdo->status_penggunaan = 'Dalam Perbaikan';
            }
            $kdo->save();
        }

        return $this->successResponse($maintenance->load('kdo'), 'Riwayat pemeliharaan berhasil dicatat.', 201);
    }

    public function show($id): JsonResponse
    {
        $item = RiwayatPemeliharaan::with(['kdo.perangkatDaerah', 'kdo.pns'])->find($id);

        if (!$item) {
            return $this->errorResponse('Data riwayat pemeliharaan tidak ditemukan.', 404);
        }

        return $this->successResponse($item, 'Detail riwayat pemeliharaan berhasil dimuat.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $item = RiwayatPemeliharaan::find($id);

        if (!$item) {
            return $this->errorResponse('Data riwayat pemeliharaan tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'tanggal_servis' => 'required|date',
            'jenis_pemeliharaan' => 'required|string|max:255',
            'bengkel_pelaksana' => 'nullable|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'kondisi_sebelum' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'kondisi_setelah' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'deskripsi' => 'nullable|string',
            'bukti_dokumen' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:4096',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $data = $request->except(['bukti_dokumen', '_method']);

        if ($request->hasFile('bukti_dokumen')) {
            if ($item->bukti_dokumen && Storage::disk('public')->exists($item->bukti_dokumen)) {
                Storage::disk('public')->delete($item->bukti_dokumen);
            }
            $data['bukti_dokumen'] = $request->file('bukti_dokumen')->store('maintenance_docs', 'public');
        }

        $item->update($data);

        return $this->successResponse($item->load('kdo'), 'Data pemeliharaan berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $item = RiwayatPemeliharaan::find($id);

        if (!$item) {
            return $this->errorResponse('Data riwayat pemeliharaan tidak ditemukan.', 404);
        }

        if ($item->bukti_dokumen && Storage::disk('public')->exists($item->bukti_dokumen)) {
            Storage::disk('public')->delete($item->bukti_dokumen);
        }

        $item->delete();

        return $this->successResponse(null, 'Data riwayat pemeliharaan berhasil dihapus.');
    }
}
