<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeanceCreateRequest;
use App\Interfaces\SeanceRepositoryInterface;
use Illuminate\Http\JsonResponse;

class SeanceController extends Controller
{
    private SeanceRepositoryInterface $seanceRepository;

    public function __construct(SeanceRepositoryInterface $seanceRepository)
    {
        $this->seanceRepository = $seanceRepository;
    }

    /**
     * Returns list of Seances populated with FilmData
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data' => $this->seanceRepository->getAllSeances(),
        ], 200);
    }

    /**
     * Stores a newly created Seance in storage.
     *
     * @param SeanceCreateRequest $request
     * @return JsonResponse
     */
    public function store(SeanceCreateRequest $request): JsonResponse
    {
        $seanceData = $request->all();
        return response()->json([
            'status' => 'ok',
            'data' => $this->seanceRepository->createSeance($seanceData),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->seanceRepository->deleteSeance([$id]);
        return response()->json([
            'status' => 'ok',
        ]);
    }
}
