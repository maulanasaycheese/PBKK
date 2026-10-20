<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSampah extends Model
{
    use HasFactory;

    protected $table = 'jenis_sampah';

    protected $fillable = ['nama', 'kategori', 'harga_per_kg', 'aktif'];

    protected $casts = [
        'harga_per_kg' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    public function detailSetoran(): HasMany
    {
        return $this->hasMany(DetailSetoran::class);
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
