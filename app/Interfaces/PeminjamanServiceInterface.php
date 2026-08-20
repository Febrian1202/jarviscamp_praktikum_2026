<?php

namespace App\Interfaces;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Collection;

interface PeminjamanServiceInterface
{
    public function getAll(): Collection;

    public function getById(Peminjaman $peminjaman): Peminjaman;

    public function createPeminjaman(array $data): Peminjaman;

    public function updatePeminjaman(Peminjaman $peminjaman, array $data): Peminjaman;

    public function deletePeminjaman(Peminjaman $peminjaman): void;

    public function pengembalian(Peminjaman $peminjaman): Peminjaman;
}
