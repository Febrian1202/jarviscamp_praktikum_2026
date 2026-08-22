<?php

namespace App\Services;

use App\Interfaces\KomikServiceInterface;
use App\Models\Komik;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Override;

class KomikService implements KomikServiceInterface
{
    #[Override]
    public function getAllKomik(): Collection
    {
        return Komik::with('kategori')->get();
    }

    #[Override]
    public function createKomik(array $data): Komik
    {
        if (isset($data['file_pdf']) && $data['file_pdf'] instanceof UploadedFile && $data['file_pdf']->isValid()) {
            $data['file_pdf'] = $data['file_pdf']->store('komiks', 'public');
        }

        return Komik::create($data)->refresh()->load('kategori');
    }

    public function getById(Komik $komik): Komik
    {
        return $komik->load('kategori');
    }

    #[Override]
    public function updateKomik(Komik $komik, array $data): Komik
    {
        if (isset($data['file_pdf']) && $data['file_pdf'] instanceof UploadedFile && $data['file_pdf']->isValid()) {
            if ($komik->file_pdf) {
                Storage::disk('public')->delete($komik->file_pdf);
            }
            $data['file_pdf'] = $data['file_pdf']->store('komiks', 'public');
        }

        $komik->update($data);

        return $komik->fresh('kategori');
    }

    #[Override]
    public function deleteKomik(Komik $komik): void
    {
        if ($komik->file_pdf) {
            Storage::disk('public')->delete($komik->file_pdf);
        }
        
        $komik->delete();
    }
}
