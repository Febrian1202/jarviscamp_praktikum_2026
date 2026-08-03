<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KomikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "judul_komik" => $this->judul,
            "penulis" => $this->penulis,
            "status_ketersediaan" => $this->status,
            "link_pdf" => $this->file_pdf,
        ];
    }
}
