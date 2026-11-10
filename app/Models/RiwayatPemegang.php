<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPemegang extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pemegangs';

    protected $fillable = [
        'kdo_id',
        'pns_id',
        'nomor_bast',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_bast',
        'catatan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function kdo(): BelongsTo
    {
        return $this->belongsTo(Kdo::class, 'kdo_id');
    }

    public function pns(): BelongsTo
    {
        return $this->belongsTo(Pns::class, 'pns_id');
    }
}
