<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kdo extends Model
{
    use HasFactory;

    protected $table = 'kdos';

    protected $fillable = [
        'perangkat_daerah_id',
        'pns_id',
        'nomor_polisi',
        'kode_barang',
        'merk',
        'tipe',
        'kategori',
        'tahun_produksi',
        'warna',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_bpkb',
        'kondisi',
        'status_penggunaan',
        'tanggal_pajak',
        'foto',
        'keterangan',
    ];

    protected $casts = [
        'tahun_produksi' => 'integer',
        'tanggal_pajak' => 'date',
    ];

    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    public function pns(): BelongsTo
    {
        return $this->belongsTo(Pns::class, 'pns_id');
    }

    public function riwayatPemeliharaans(): HasMany
    {
        return $this->hasMany(RiwayatPemeliharaan::class, 'kdo_id')->orderBy('tanggal_servis', 'desc');
    }

    public function riwayatPemegangs(): HasMany
    {
        return $this->hasMany(RiwayatPemegang::class, 'kdo_id')->orderBy('tanggal_mulai', 'desc');
    }
}
