<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        api: __DIR__ . "/../routes/api.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if (!$request->is("api/*")) {
                return null;
            }

            if (
                $e instanceof ModelNotFoundException ||
                $e->getPrevious() instanceof ModelNotFoundException
            ) {
                $modelName = "Data";

                $exception =
                    $e instanceof ModelNotFoundException
                        ? $e
                        : $e->getPrevious();

                if (str_contains($exception->getModel(), "Anggota")) {
                    $modelName = "Anggota";
                } elseif (str_contains($exception->getModel(), "Kategori")) {
                    $modelName = "Kategori";
                } elseif (str_contains($exception->getModel(), "Komik")) {
                    $modelName = "Komik";
                }

                return response()->json(
                    [
                        "success" => false,
                        "message" => "{$modelName} tidak ditemukan",
                        "data" => null,
                    ],
                    404,
                );
            }

            if ($e instanceof ValidationException) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Validasi data gagal",
                        "data" => $e->errors(),
                    ],
                    $e->status,
                );
            }

            if ($e instanceof HttpExceptionInterface) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $e->getMessage() ?: "Terjadi kesalahan.",
                        "data" => null,
                    ],
                    $e->getStatusCode(),
                );
            }

            return response()->json(
                [
                    "success" => false,
                    "message" =>
                        $e->getMessage() ?: "Terjadi kesalahan pada server.",
                    "data" => null,
                ],
                500,
            );
        });
    })
    ->create();
