<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeanceController extends Controller
{
    /**
     * Returns list of Seances populated with FilmData
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $data = Seance::all()->map(function ($seance) {
                return [
                    'id' => $seance->id,
                    'startTime' => $seance->startTime,
                    'hallId' => $seance->hallId,
                    'filmId' => $seance->filmId,
                    'filmData' => Film::find($seance->filmId),
                    'hallData' => Hall::find($seance->hallId),
                ];
            });
            return response()->json([
                'status' => 'ok',
                'data' => $data,
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        //TODO:add validation
        try {
            error_log(implode(' ', $request->all()));
            $new = Seance::create($request->all());
            return response()->json([
               'status' => 'ok',
               'data' => $new,
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'data' => "DB error: can't create seance",
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function edit(Seance $seance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seance $seance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seance  $seance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seance $seance)
    {
        //
    }
}
