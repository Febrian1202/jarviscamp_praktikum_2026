<?php

namespace App\Services;

use App\Interfaces\KategoriServiceInterface;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;

class KategoriService implements KategoriServiceInterface
{
    public function getAllKategori(): Collection
    {
        return Kategori::all();
    }

    public function createKategori(array $data): Kategori
    {
        return Kategori::create($data);
    }

    public function updateKategori(Kategori $kategori, array $data): Kategori
    {
        $kategori->update($data);

        return $kategori->fresh();
    }

    public function deleteKategori(Kategori $kategori): void
    {
        $kategori->delete();
    }
}
