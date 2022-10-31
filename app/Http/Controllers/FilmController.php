<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilmCreateRequest;
use App\Interfaces\FilmRepositoryInterface;
use Illuminate\Http\JsonResponse;

class FilmController extends Controller
{
    private FilmRepositoryInterface $filmRepository;

    public function __construct(FilmRepositoryInterface $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->filmRepository->getAllFilms(),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    public function store(FilmCreateRequest $request): JsonResponse
    {
        $filmData = $request->all();
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->filmRepository->createFilm($filmData),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->filmRepository->deleteFilm([$id]);
            return response()->json([
                'status' => 'ok',
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }
}
