<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kdo;
use App\Models\RiwayatPemegang;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KdoController extends Controller
{
    use ApiResponse;

    public function index(Request $request): JsonResponse
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_polisi', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('nomor_rangka', 'like', "%{$search}%")
                  ->orWhere('nomor_mesin', 'like', "%{$search}%")
                  ->orWhere('warna', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 50);
        $data = $query->orderBy('id', 'desc')->paginate($perPage);

        return $this->successResponse($data, 'Daftar KDO berhasil dimuat.');
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'perangkat_daerah_id' => 'required|exists:perangkat_daerahs,id',
            'pns_id' => 'nullable|exists:pns,id',
            'nomor_polisi' => 'required|string|max:20|unique:kdos,nomor_polisi',
            'kode_barang' => 'nullable|string|max:50',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:100',
            'kategori' => 'required|in:Roda 4,Roda 2,Roda 6,Lainnya',
            'tahun_produksi' => 'required|digits:4|integer|min:1980|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'nomor_rangka' => 'nullable|string|max:100',
            'nomor_mesin' => 'nullable|string|max:100',
            'nomor_bpkb' => 'nullable|string|max:100',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status_penggunaan' => 'required|in:Digunakan,Tersedia/Pool,Dalam Perbaikan',
            'tanggal_pajak' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'keterangan' => 'nullable|string',
        ], [
            'nomor_polisi.required' => 'Nomor Polisi wajib diisi.',
            'nomor_polisi.unique' => 'Nomor Polisi sudah terdaftar.',
            'merk.required' => 'Merk kendaraan wajib diisi.',
            'tipe.required' => 'Tipe / model kendaraan wajib diisi.',
            'tahun_produksi.required' => 'Tahun produksi wajib diisi.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kdo_photos', 'public');
            $data['foto'] = $path;
        }

        $kdo = Kdo::create($data);

        // Jika langsung ditentukan pemegang PNS, catat ke riwayat pemegang
        if (!empty($kdo->pns_id)) {
            RiwayatPemegang::create([
                'kdo_id' => $kdo->id,
                'pns_id' => $kdo->pns_id,
                'nomor_bast' => '028/' . rand(100, 999) . '/BAST-KDO/' . date('Y'),
                'tanggal_mulai' => now()->toDateString(),
                'status_bast' => 'Aktif',
                'catatan' => 'Penetapan awal penanggung jawab kendaraan dinas operasional.',
            ]);
        }

        return $this->successResponse($kdo->load(['perangkatDaerah', 'pns']), 'Data KDO berhasil ditambahkan.', 201);
    }

    public function show($id): JsonResponse
    {
        $kdo = Kdo::with([
            'perangkatDaerah',
            'pns',
            'riwayatPemeliharaans' => function ($q) {
                $q->orderBy('tanggal_servis', 'desc');
            },
            'riwayatPemegangs' => function ($q) {
                $q->with('pns')->orderBy('tanggal_mulai', 'desc');
            }
        ])->find($id);

        if (!$kdo) {
            return $this->errorResponse('Data KDO tidak ditemukan.', 404);
        }

        return $this->successResponse($kdo, 'Detail KDO berhasil dimuat.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $kdo = Kdo::find($id);

        if (!$kdo) {
            return $this->errorResponse('Data KDO tidak ditemukan.', 404);
        }

        $validator = Validator::make($request->all(), [
            'perangkat_daerah_id' => 'required|exists:perangkat_daerahs,id',
            'pns_id' => 'nullable|exists:pns,id',
            'nomor_polisi' => 'required|string|max:20|unique:kdos,nomor_polisi,' . $id,
            'kode_barang' => 'nullable|string|max:50',
            'merk' => 'required|string|max:50',
            'tipe' => 'required|string|max:100',
            'kategori' => 'required|in:Roda 4,Roda 2,Roda 6,Lainnya',
            'tahun_produksi' => 'required|digits:4|integer|min:1980|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'nomor_rangka' => 'nullable|string|max:100',
            'nomor_mesin' => 'nullable|string|max:100',
            'nomor_bpkb' => 'nullable|string|max:100',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'status_penggunaan' => 'required|in:Digunakan,Tersedia/Pool,Dalam Perbaikan',
            'tanggal_pajak' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi data gagal.', 422, $validator->errors());
        }

        $oldPnsId = $kdo->pns_id;
        $data = $request->except(['foto', '_method']);

        if ($request->hasFile('foto')) {
            if ($kdo->foto && Storage::disk('public')->exists($kdo->foto)) {
                Storage::disk('public')->delete($kdo->foto);
            }
            $data['foto'] = $request->file('foto')->store('kdo_photos', 'public');
        }

        $kdo->update($data);

        // Jika terjadi pergantian pemegang PNS
        if ($oldPnsId != $request->pns_id) {
            // Tutup BAST aktif sebelumnya jika ada
            if ($oldPnsId) {
                RiwayatPemegang::where('kdo_id', $kdo->id)
                    ->where('pns_id', $oldPnsId)
                    ->where('status_bast', 'Aktif')
                    ->update([
                        'tanggal_selesai' => now()->toDateString(),
                        'status_bast' => 'Selesai',
                        'catatan' => 'Alih tanggung jawab / pengembalian kendaraan dinas.',
                    ]);
            }

            // Buka BAST baru jika PNS baru ditentukan
            if (!empty($request->pns_id)) {
                RiwayatPemegang::create([
                    'kdo_id' => $kdo->id,
                    'pns_id' => $request->pns_id,
                    'nomor_bast' => '028/' . rand(100, 999) . '/BAST-KDO/' . date('Y'),
                    'tanggal_mulai' => now()->toDateString(),
                    'status_bast' => 'Aktif',
                    'catatan' => 'Pergantian penanggung jawab pemegang kendaraan.',
                ]);
            }
        }

        return $this->successResponse($kdo->load(['perangkatDaerah', 'pns']), 'Data KDO berhasil diperbarui.');
    }

    public function destroy($id): JsonResponse
    {
        $kdo = Kdo::find($id);

        if (!$kdo) {
            return $this->errorResponse('Data KDO tidak ditemukan.', 404);
        }

        if ($kdo->foto && Storage::disk('public')->exists($kdo->foto)) {
            Storage::disk('public')->delete($kdo->foto);
        }

        $kdo->delete();

        return $this->successResponse(null, 'Data KDO berhasil dihapus.');
    }
}
