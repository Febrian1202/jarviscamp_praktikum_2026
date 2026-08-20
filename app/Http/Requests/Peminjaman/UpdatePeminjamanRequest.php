<?php

namespace App\Http\Requests\Peminjaman;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePeminjamanRequest extends FormRequest
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
            'anggota_id' => ['sometimes', 'integer', 'exists:anggota,id'], // |exists:anggota,id|exists:anggota,id"],
            'komik_id' => ['sometimes', 'integer', 'exists:komik,id'],
            'tanggal_pinjam' => ['sometimes', 'date'],
            'tanggal_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
            'status' => ['sometimes', 'in:dipinjam,dikembalikan,telat'],
        ];
    }

    public function messages(): array
    {
        return [
            'anggota_id.integer' => 'ID Anggota harus berupa angka',
            'anggota_id.exists' => 'ID Anggota tidak valid',

            'komik_id.integer' => 'ID Komik harus berupa angka',
            'komik_id.exists' => 'ID Komik tidak valid',

            'tanggal_pinjam.date' => 'Tanggal Pinjam tidak valid',

            'tanggal_kembali.date' => 'Tanggal Kembali tidak valid',
            'tanggal_kembali.after_or_equal' => 'Tanggal Kembali tidak boleh sebelum tanggal pinjam',

            'status.in' => 'Status tidak valid',
        ];
    }
}
