<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketCreateRequest;
use App\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TicketCreateRequest $request
     * @return JsonResponse
     */
    public function store(TicketCreateRequest $request): JsonResponse
    {
            $ticketData = $request->all();
            try {
                return response()->json([
                    'status' => 'ok',
                    'data' => $this->ticketRepository->createTicket($ticketData),
                ], 200);
            } catch (\Exception $e) {
                error_log($e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'data' => $e->getMessage(),
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
        $ticketDetails = [
            'date' => $date,
            'seance' => $seance,
        ];
        try {
            return response()->json([
                'status' => 'ok',
                'data' => $this->ticketRepository->getTickets($ticketDetails),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
            ], 500);
        }
    }
}
