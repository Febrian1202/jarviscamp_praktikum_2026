<?php

namespace App\Http\Requests\Peminjaman;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StorePeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "anggota_id" => ["required", "integer", "exists:anggota,id"], //|exists:anggota,id|exists:anggota,id"],
            "komik_id" => ["required", "integer", "exists:komik,id"],
            "tanggal_pinjam" =>  ["required", "date"],
            "status" => ["required", "in:dipinjam,dikembalikan,telat"],
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            "anggota_id.required" => "ID Anggota tidak boleh kosong",
            "anggota_id.integer" => "ID Anggota harus berupa angka",
            "anggota_id.exists" => "ID Anggota tidak valid",

            "komik_id.required" => "ID Komik tidak boleh kosong",
            "komik_id.exists" => "ID Komik tidak valid",

            "tanggal_pinjam.required" => "Tanggal Pinjam tidak boleh kosong",
            "tanggal_pinjam.date" => "Tanggal Pinjam tidak valid",

            "status.required" => "Status tidak boleh kosong",
            "status.in" => "Status tidak valid",
        ];
    }
}
