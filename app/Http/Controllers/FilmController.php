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
        return response()->json([
            'status' => 'ok',
            'data' => $this->filmRepository->getAllFilms(),
        ], 200);
    }

    public function store(FilmCreateRequest $request): JsonResponse
    {
        $filmData = $request->all();
        if ($request->hasFile('imageFile')) {
            error_log('has file');
        }
        return response()->json([
            'status' => 'ok',
            'data' => $this->filmRepository->createFilm($filmData, $request->file('imageFile')),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->filmRepository->deleteFilm($id);
        return response()->json([
            'status' => 'ok',
        ], 200);
    }
}
