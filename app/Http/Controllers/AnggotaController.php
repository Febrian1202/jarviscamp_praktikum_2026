<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::all();

        return $this->successResponse($anggota, "List anggota");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:255",
            "no_hp" => "required|string|max:20",
            "alamat" => "required|string",
            "tanggal_daftar" => "required|date",
        ]);

        $anggota = Anggota::create($validated);

        return $this->successResponse(
            $anggota,
            "Berhasil membuat data anggota",
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return $this->errorResponse(null, "Anggota tidak ditemukan", 404);
        }

        return $this->successResponse(
            $anggota,
            "Berhasil mengambil data anggota",
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return $this->errorResponse(null, "Anggota tidak ditemukan", 404);
        }

        $validated = $request->validate([
            "nama" => "sometimes|string|max:255",
            "no_hp" => "sometimes|string|max:255",
            "alamat" => "sometimes|string",
            "tanggal_daftar" => "sometimes|date",
        ]);

        $anggota->update($validated);

        return $this->successResponse(
            $anggota,
            "Data anggota berhasil diupdate",
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::find($id);

        if (!$anggota) {
            return $this->errorResponse(null, "Anggota tidak ditemukan", 404);
        }

        $anggota->delete();

        return $this->successResponse(null, "Anggota berhasil dihapus");
    }
}
