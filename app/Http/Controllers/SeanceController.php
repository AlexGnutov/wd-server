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
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->seanceRepository->getAllSeances(),
            ], 200);
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            return response()->json([
                'status' => 'error',
                'data' => "DB Error: can't load seances",
            ], 500);
        }
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
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->seanceRepository->createSeance($seanceData),
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => "DB error: can't create seance",
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->seanceRepository->deleteSeance([$id]);
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
