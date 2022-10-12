<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $films = Film::all();
            return response()->json([
                'status' => 'ok',
                'data' => $films,
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());

            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        //
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
            $newFilm = Film::create($all);
            return response()->json([
                'status' => 'ok',
                'data' => $newFilm,
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show(Film $film)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function edit(Film $film)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Film $film)
    {
        //
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
            Film::destroy([$id]);
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
