<?php

namespace App\Http\Controllers;

use App\Http\Requests\Komik\StoreKomikRequest;
use App\Http\Requests\Komik\UpdateKomikRequest;
use App\Http\Resources\KomikResource;
use App\Models\Komik;
use App\Traits\ApiResponse;

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

        $data = KomikResource::collection($komik);

        return $this->successResponse($data, 'List of komik');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKomikRequest $request)
    {
        $validated = $request->validated();

        $komik = Komik::create($validated);

        $data = new KomikResource($komik);

        return $this->successResponse($data, 'Sukses membuat data komik', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $komik = Komik::findOrFail($id);

        $data = new KomikResource($komik);

        return $this->successResponse($data, 'Komik ditemukan', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKomikRequest $request, string $id)
    {
        $komik = Komik::findOrFail($id);

        $validated = $request->validated();

        $komik->update($validated);

        $data = new KomikResource($komik);

        return $this->successResponse(
            $data,
            'Data komik berhasil diupdate',
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $komik = Komik::findOrFail($id);

        $komik->delete();

        return $this->successResponse(null, 'Data komik berhasil dihapus', 200);
    }
}
