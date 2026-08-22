<?php

namespace App\Http\Requests\Komik;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreKomikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "judul" => ["required", "string", "max:255", "min:1"],
            "kategori_id" => ["required", "integer", "exists:kategoris,id"],
            "stok" => ["required", "integer", "min:0"],
            "penulis" => ["required", "string", "max:255", "min:1"],
            "file_pdf" => ["nullable", "file", "mimes:pdf", "max:2048"],
            "status" => ["sometimes", "string", "in:available,unavailable"],
        ];
    }

    /**
     * Pesan custom untuk validasi
     */
    #[Override]
    public function messages(): array
    {
        return [
            "judul.required" => "Judul harus diisi",
            "judul.max" => "Judul tidak boleh lebih dari 255 karakter",
            "judul.min" => "Judul tidak boleh kosong",
            "judul.string" => "Judul harus berupa string/karakter",

            "kategori_id.required" => "Kategori harus dipilih",
            "kategori_id.integer" => "Kategori harus berupa angka",
            "kategori_id.exists" => "Kategori tidak valid",

            "stok.required" => "Stok harus diisi",
            "stok.integer" => "Stok harus berupa angka",
            "stok.min" => "Stok tidak boleh kurang dari 0",

            "penulis.required" => "Penulis harus diisi",
            "penulis.string" => "Penulis harus berupa string/karakter",
            "penulis.max" => "Penulis tidak boleh lebih dari 255 karakter",
            "penulis.min" => "Penulis tidak boleh kosong",

            "file_pdf.file" => "File harus berupa file",
            "file_pdf.mimes" => "File harus berupa PDF",
            "file_pdf.max" => "File tidak boleh lebih dari 2MB",

            "status.string" => "Status harus berupa string/karakter",
            "status.in" => "Status tidak valid",
        ];
    }
}
