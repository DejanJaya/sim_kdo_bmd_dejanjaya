<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pns extends Model
{
    use HasFactory;

    protected $table = 'pns';

    protected $fillable = [
        'perangkat_daerah_id',
        'nip',
        'nama',
        'jabatan',
        'golongan',
        'no_telepon',
        'email',
        'status_pegawai',
    ];

    public function perangkatDaerah(): BelongsTo
    {
        return $this->belongsTo(PerangkatDaerah::class, 'perangkat_daerah_id');
    }

    public function kdos(): HasMany
    {
        return $this->hasMany(Kdo::class, 'pns_id');
    }

    public function riwayatPemegangs(): HasMany
    {
        return $this->hasMany(RiwayatPemegang::class, 'pns_id');
    }
}
