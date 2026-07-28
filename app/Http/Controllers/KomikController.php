<?php

namespace App\Http\Controllers;

use App\Models\Komik;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class KomikController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     * Metode Request GET
     */
    public function index()
    {
        $komik = Komik::all();

        return $this->successResponse($komik, "List of komik");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "judul" => "required|string|max:255",
            "kategori_id" => "required|integer|min:0",
            "stok" => "required|integer|min:0",
            "penulis" => "required|string|max:255",
            "tanggal_terbit" => "required|date",
        ]);

        $komik = Komik::create($validated);

        return $this->successResponse($komik, "Sukses membuat data komik", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $komik = Komik::find($id);

        if (!$komik) {
            return $this->errorResponse(null, "Komik tidak ditemukan", 404);
        }

        return $this->successResponse($komik, "Komik ditemukan", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $komik = Komik::find($id);

        if (!$komik) {
            return $this->errorResponse(null, "Komik tidak ditemukan", 404);
        }

        $validated = $request->validate([
            "judul" => "sometimes|string|max:255",
            "kategori_id" => "sometimes|integer|min:0",
            "stok" => "sometimes|integer|min:0",
            "penulis" => "sometimes|string|max:255",
            "tanggal_terbit" => "sometimes|date",
        ]);

        $komik->update($validated);

        return $this->successResponse(
            $komik,
            "Data komik berhasil diupdate",
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $komik = Komik::find($id);

        if (!$komik) {
            return $this->errorResponse(null, "Komik tidak ditemukan", 404);
        }

        $komik->delete();

        return $this->successResponse(null, "Data komik berhasil dihapus", 200);
    }
}
