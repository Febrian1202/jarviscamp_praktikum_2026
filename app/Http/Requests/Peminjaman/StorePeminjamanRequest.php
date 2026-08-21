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
            "anggota_id" => ["required", "integer", "exists:anggotas,id"], 
            "komik_id" => ["required", "integer", "exists:komiks,id"],
            "tanggal_peminjaman" =>  ["required", "date"],
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

            "tanggal_peminjaman.required" => "Tanggal Pinjam tidak boleh kosong",
            "tanggal_peminjaman.date" => "Tanggal Pinjam tidak valid",
        ];
    }
}
