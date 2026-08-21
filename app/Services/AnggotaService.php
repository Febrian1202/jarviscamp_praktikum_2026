<?php

namespace App\Services;

use App\Interfaces\AnggotaServiceInterface;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Collection;
use Override;

class AnggotaService implements AnggotaServiceInterface
{
    #[Override]
    public function getAllAnggota(): Collection
    {
        return Anggota::all();
    }

    #[Override]
    public function createAnggota(array $data): Anggota
    {
        return Anggota::create($data);
    }

    #[Override]
    public function updateAnggota(Anggota $anggota, array $data): Anggota
    {
        $anggota->fill($data);
        $anggota->save();
        return $anggota->fresh();
    }

    #[Override]
    public function deleteAnggota(Anggota $anggota): void
    {
        $anggota->delete();
    }
}
