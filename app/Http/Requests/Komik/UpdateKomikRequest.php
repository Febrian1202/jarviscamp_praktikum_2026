<?php

namespace App\Http\Requests\Komik;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateKomikRequest extends FormRequest
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
            "judul" => ["sometimes", "string", "max:255", "min:1"],
            "kategori_id" => ["sometimes", "exists:kategoris,id"],
            "stok" => ["sometimes", "integer", "min:0"],
            "status" => ["sometimes", "string", "in:available,unavailable"],
            "file_pdf" => ["nullable", "file", "mimes:pdf", "max:2048"],
            "penulis" => ["sometimes", "string", "max:255", "min:1"],
            "tanggal_terbit" => ["sometimes", "date"],
        ];
    }

    /**
     * Pesan custom untuk validasi
     */

    #[Override]
    public function messages()
    {
        return [
            "judul.max" => "Judul tidak boleh lebih dari 255 karakter",
            "judul.string" => "Judul harus berupa string/karakter",
            "judul.min" => "Judul tidak boleh kosong",

            "kategori_id.exists" => "Kategori tidak valid",

            "stok.integer" => "Stok harus berupa angka",
            "stok.min" => "Stok tidak boleh kurang dari 0",

            "penulis.string" => "Penulis harus berupa string/karakter",
            "penulis.max" => "Penulis tidak boleh lebih dari 255 karakter",
            "penulis.min" => "Penulis tidak boleh kosong",

            "file_pdf.mimes" => "File harus berupa PDF",
            "file_pdf.max" => "File tidak boleh lebih dari 2MB",

            "status.string" => "Status harus berupa string/karakter",
            "status.in" => "Status tidak valid",

            "tanggal_terbit.date" => "Tanggal terbit harus berupa tanggal",
        ];
    }
}
