<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    "anggota_id",
    "komik_id",
    "tanggal_peminjaman",
    "tanggal_pengembalian",
    "status",
])]
#[Table('peminjaman')]
class Peminjaman extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamanFactory> */
    use HasFactory;

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function komik(): BelongsTo
    {
        return $this->belongsTo(Komik::class);
    }

}
