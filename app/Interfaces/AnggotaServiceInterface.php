<?php

namespace App\Interfaces;

use App\Models\Anggota;
use Illuminate\Database\Eloquent\Collection;

interface AnggotaServiceInterface
{
    public function getAllAnggota(): Collection;
    public function createAnggota(array $data): Anggota;
    public function updateAnggota(Anggota $anggota, array $data): Anggota;
    public function deleteAnggota(Anggota $anggota): void;
}
