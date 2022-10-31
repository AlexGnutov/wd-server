<?php

namespace App\Http\Controllers;

use App\Http\Requests\HallUpdateRequest;
use App\Interfaces\HallRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HallController extends Controller
{
    private HallRepositoryInterface $hallRepository;

    public function __construct(HallRepositoryInterface $hallRepository)
    {
        $this->hallRepository = $hallRepository;
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
                'data' => $this->hallRepository->getAllHalls(),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $hallData = $request->all();
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->hallRepository->createHall($hallData),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HallUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(HallUpdateRequest $request, $id): JsonResponse
    {
        $updateHallData = $request->all();
        try {
            return response()->json([
                    'status' => 'ok',
                    'data' => $this->hallRepository->updateHall($id, $updateHallData),
                ], 200);
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->hallRepository->deleteHall($id);
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
