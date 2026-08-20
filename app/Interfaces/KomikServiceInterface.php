<?php

namespace App\Interfaces;

use App\Models\Komik;
use Illuminate\Database\Eloquent\Collection;

interface KomikServiceInterface
{
    public function getAllKomik(): Collection;

    public function getById(Komik $komik): Komik;

    public function createKomik(array $data): Komik;

    public function updateKomik(Komik $komik, array $data): Komik;

    public function deleteKomik(Komik $komik): void;
}
