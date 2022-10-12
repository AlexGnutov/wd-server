<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $halls = Hall::all();
            return response()->json([
                'status' => 'ok',
                'data' => $halls,
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
        $all = $request->all();
        //TODO: make validation
        try {
            $newHall = Hall::create($all);
            return response()->json([
                'status' => 'ok',
                'data' => $newHall,
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
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $hall = Hall::findOrFail($id);
            error_log(gettype($hall));
            if ($hall) {
                $hall->fill($request->all());
                $hall->save();
                return response()->json([
                    'status' => 'ok',
                    'data' => $hall,
                ], 200);
            }
        } catch (\Exception $th) {
            return response()->json([
                'status' => 'error'
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Hall $hall
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            Hall::destroy([$id]);
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
