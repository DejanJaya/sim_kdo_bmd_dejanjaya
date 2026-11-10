<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerangkatDaerah extends Model
{
    use HasFactory;

    protected $table = 'perangkat_daerahs';

    protected $fillable = [
        'kode_pd',
        'nama_pd',
        'singkatan',
        'alamat',
        'telepon',
        'nama_kepala',
        'nip_kepala',
    ];

    public function pns(): HasMany
    {
        return $this->hasMany(Pns::class, 'perangkat_daerah_id');
    }

    public function kdos(): HasMany
    {
        return $this->hasMany(Kdo::class, 'perangkat_daerah_id');
    }
}
