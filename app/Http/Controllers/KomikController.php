<?php

namespace App\Http\Controllers;

use App\Models\Komik;
use Illuminate\Http\Request;

class KomikController extends Controller
{
    /**
     * Display a listing of the resource.
     * Metode Request GET
     */
    public function index()
    {
        $komik = Komik::all();

        return response()->json([
            "message" => "List of komik",
            "data" => $komik,
        ]);
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

        return response()->json(
            [
                "message" => "Komik created successfully",
                "data" => $komik,
            ],
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $komik = Komik::find($id);

        if (!$komik) {
            return response()->json(
                [
                    "message" => "Komik not found",
                    "data" => null,
                ],
                404,
            );
        }

        return response()->json(
            [
                "message" => "Komik found",
                "data" => $komik,
            ],
            200,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $komik = Komik::find($id);

        if (!$komik) {
            return response()->json(
                [
                    "message" => "Komik not found",
                    "data" => null,
                ],
                404,
            );
        }

        $validated = $request->validate([
            "judul" => "sometimes|string|max:255",
            "kategori_id" => "sometimes|integer|min:0",
            "stok" => "sometimes|integer|min:0",
            "penulis" => "sometimes|string|max:255",
            "tanggal_terbit" => "sometimes|date",
        ]);

        $komik->update($validated);

        return response()->json(
            [
                "message" => "Komik updated successfully",
                "data" => $komik,
            ],
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
            return response()->json(
                [
                    "message" => "Komik not found",
                    "data" => null,
                ],
                404,
            );
        }

        $komik->delete();

        return response()->json(
            [
                "message" => "Komik deleted successfully",
                "data" => null,
            ],
            200,
        );
    }
}
