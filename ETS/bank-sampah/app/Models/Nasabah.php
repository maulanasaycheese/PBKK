<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nasabah extends Model
{
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = ['kode_nasabah', 'nama', 'alamat', 'no_hp', 'status'];

    public function setoran(): HasMany
    {
        return $this->hasMany(Setoran::class);
    }

    public function penarikan(): HasMany
    {
        return $this->hasMany(Penarikan::class);
    }

    // Saldo = total setoran - total penarikan
    public function getSaldoAttribute(): float
    {
        return (float) $this->setoran()->sum('total_nilai')
             - (float) $this->penarikan()->sum('nominal');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeCari($query, ?string $kata)
    {
        return $kata
            ? $query->where(fn ($q) => $q->where('nama', 'like', "%{$kata}%")
                                         ->orWhere('kode_nasabah', 'like', "%{$kata}%"))
            : $query;
    }
}
