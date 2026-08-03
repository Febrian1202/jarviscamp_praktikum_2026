<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UpdateAnggotaRequest extends FormRequest
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
            "nama" => ["sometimes", "string", "max:255", "min:1"],
            "no_hp" => [
                "sometimes",
                "string",
                "max:20",
                "min:1",
                'regex:/^(0|62|\+62)8[1-9][0-9]{6,11}$/',
            ],
            "alamat" => ["sometimes", "string"],
            "tanggal_daftar" => ["sometimes", "date"],
        ];
    }

    /**
     * Override message validasi
     */
    #[Override]
    public function messages()
    {
        return [
            "nama.string" => "Nama anggota harus berupa string/karakter",
            "nama.max" => "Nama anggota tidak boleh lebih dari 255 karakter",
            "nama.min" => "Nama anggota tidak boleh kosong",

            "no_hp.string" => "Nomor hape anggota harus berupa string/karakter",
            "no_hp.max" => "Nomor hape tidak boleh lebih dari 20 karakter",
            "no_hp.min" => "Nomor hape tidak boleh kosong",
            "no_hp.regex" =>
                "Nomor hape tidak valid harus dalam format 08xxxxxxxx (Indonesia)",

            "alamat.string" => "Alamat anggota harus berupa string/karakter",

            "tanggal_daftar.date" =>
                "Tanggal pendaftaraan harus berupa format date (YYYY-MM-DD). ex: 2026-12-30",
        ];
    }
}
