<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TicketController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->has(['date', 'seanceId', 'seats'])) {
            $data = $request->all();
            try {
                $ticket = Ticket::create([
                    'date' => $data['date'],
                    'seanceId' => $data['seanceId'],
                    'seats' => json_encode($data['seats']),
                ]);

                $seance = \App\Models\Seance::where('id', '=', $ticket->seanceId)->first();
                $hall = \App\Models\Hall::where('id', '=', $seance->hallId)->first();
                $film = \App\Models\Film::where('id', '=', $seance->filmId)->first();

                return response()->json([
                    'status' => 'ok',
                    'data' => [
                        'seanceId' => $ticket->seanceId,
                        'hallTitle' => $hall->title,
                        'filmTitle' => $film->title,
                        'seats' => $ticket->seats,
                        'startTime' => $seance->startTime,
                    ],
                ], 200);

            } catch (\Exception $e) {
                error_log($e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'data' => $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'data' => 'no necessary data provided',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $seance
     * @param $date
     * @return JsonResponse
     */
    public function show($seance, $date): JsonResponse
    {
        try {
            $tickets = Ticket::where('date', '=', $date)
                ->where('seanceId', '=', $seance)->get();
            return response()->json([
                'status' => 'ok',
                'data' => $tickets,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }




}
