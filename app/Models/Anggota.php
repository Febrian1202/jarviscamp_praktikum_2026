<?php

namespace App\Models;

use Database\Factories\AnggotaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(["nama", "no_hp", "alamat", "tanggal_daftar"])]
class Anggota extends Model
{
    /** @use HasFactory<AnggotaFactory> */
    use HasFactory;

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
