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
            "judul" => $this->judul,
            "penulis" => $this->penulis,
            "kategori_id" => $this->kategori_id,
            "nama_kategori" => $this->whenLoaded("kategori", fn () => $this->kategori->nama_kategori),
            "stok" => $this->stok,
            "status" => $this->status,
            "file_pdf" => $this->file_pdf,
            "created_at" => $this->created_at?->format("Y-m-d H:i:s"),
            "updated_at"=> $this->updated_at?->format("Y-m-d H:i:s"),
        ];
    }
}
