<?php

namespace App\Http\Controllers;

use App\Http\Requests\Komik\StoreKomikRequest;
use App\Http\Requests\Komik\UpdateKomikRequest;
use App\Http\Resources\KomikResource;
use App\Interfaces\KomikServiceInterface;
use App\Models\Komik;
use App\Traits\ApiResponse;

class KomikController extends Controller
{
    use ApiResponse;

    public function __construct(private KomikServiceInterface $komikService) {}

    /**
     * Display a listing of the resource.
     * Metode Request GET
     */
    public function index()
    {
        $komik = $this->komikService->getAllKomik();

        return $this->successResponse(
            KomikResource::collection($komik),
            'List of komik',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKomikRequest $request)
    {
        $komik = $this->komikService->createKomik($request->validated());

        return $this->successResponse(
            new KomikResource($komik),
            'Sukses membuat data komik',
            201,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Komik $komik)
    {
        $data = $this->komikService->getById($komik);

        return $this->successResponse(
            new KomikResource($data),
            'Komik ditemukan',
            200,
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKomikRequest $request, Komik $komik)
    {
        $komik = $this->komikService->updateKomik(
            $komik,
            $request->validated(),
        );

        return $this->successResponse(
            new KomikResource($komik),
            'Data komik berhasil diupdate',
            200,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komik $komik)
    {
        $this->komikService->deleteKomik($komik);

        return $this->successResponse(null, 'Data komik berhasil dihapus', 200);
    }
}
