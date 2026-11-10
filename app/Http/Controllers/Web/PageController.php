<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Kdo;
use App\Models\PerangkatDaerah;
use App\Models\Pns;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function perangkatDaerah(): View
    {
        return view('perangkat-daerah.index');
    }

    public function pns(): View
    {
        $perangkatDaerahs = PerangkatDaerah::orderBy('nama_pd')->get();
        return view('pns.index', compact('perangkatDaerahs'));
    }

    public function kdo(): View
    {
        $perangkatDaerahs = PerangkatDaerah::orderBy('nama_pd')->get();
        $pnsList = Pns::with('perangkatDaerah')->where('status_pegawai', 'Aktif')->orderBy('nama')->get();
        return view('kdo.index', compact('perangkatDaerahs', 'pnsList'));
    }

    public function pemeliharaan(): View
    {
        $kdos = Kdo::with('perangkatDaerah')->orderBy('nomor_polisi')->get();
        return view('pemeliharaan.index', compact('kdos'));
    }

    public function laporan(): View
    {
        $perangkatDaerahs = PerangkatDaerah::orderBy('nama_pd')->get();
        return view('laporan.index', compact('perangkatDaerahs'));
    }

    public function cetakLaporan(Request $request): View
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
        $pdTerpilih = $request->filled('perangkat_daerah_id')
            ? PerangkatDaerah::find($request->perangkat_daerah_id)
            : null;

        return view('laporan.cetak', compact('kdos', 'pdTerpilih', 'request'));
    }

    public function cetakKdo($id): View
    {
        $kdo = Kdo::with(['perangkatDaerah', 'pns', 'riwayatPemeliharaans', 'riwayatPemegangs.pns'])->findOrFail($id);
        return view('kdo.cetak-kartu', compact('kdo'));
    }

    public function apiDocs(): View
    {
        return view('api-docs');
    }
}
