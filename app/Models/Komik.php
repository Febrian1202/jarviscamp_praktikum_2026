<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(["judul", "penulis", "kategori_id", "stok", "status", "file_pdf"])]
class Komik extends Model
{
    /** @use HasFactory<\Database\Factories\KomikFactory> */
    use HasFactory;
}
