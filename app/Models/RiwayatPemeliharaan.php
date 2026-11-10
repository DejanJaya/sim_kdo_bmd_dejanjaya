<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pemeliharaans';

    protected $fillable = [
        'kdo_id',
        'tanggal_servis',
        'jenis_pemeliharaan',
        'bengkel_pelaksana',
        'biaya',
        'kondisi_sebelum',
        'kondisi_setelah',
        'deskripsi',
        'bukti_dokumen',
    ];

    protected $casts = [
        'tanggal_servis' => 'date',
        'biaya' => 'decimal:2',
    ];

    public function kdo(): BelongsTo
    {
        return $this->belongsTo(Kdo::class, 'kdo_id');
    }
}
