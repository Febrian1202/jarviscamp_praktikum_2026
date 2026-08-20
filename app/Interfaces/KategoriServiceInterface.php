<?php

namespace App\Interfaces;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;

interface KategoriServiceInterface
{
    public function getAllKategori(): Collection;
    public function createKategori(array $data): Kategori;
    public function updateKategori(Kategori $kategori, array $data): Kategori;
    public function deleteKategori(Kategori $kategori): void;
}
