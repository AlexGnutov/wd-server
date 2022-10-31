<?php

namespace App\Repositories;

use App\Interfaces\SeanceRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SeanceRepository implements SeanceRepositoryInterface {

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository) {
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllSeances(): Collection|\Illuminate\Support\Collection
    {
        return Seance::all()->map(function ($seance) {
            return [
                'id' => $seance->id,
                'startTime' => $seance->startTime,
                'hallId' => $seance->hallId,
                'filmId' => $seance->filmId,
                'filmData' => Film::find($seance->filmId),
                'hallData' => Hall::find($seance->hallId),
            ];
        });
    }

    public function createSeance($seanceData)
    {
        return Seance::create($seanceData);
    }

    public function findSeances($key, $value): Collection
    {
        return Seance::where($key, '=', $value)->get();
    }

    /**
     * Deletes seances only
     * @param array $seanceIds
     * @return int
     */
    public function deleteSeances(array $seanceIds): int
    {
        return Seance::destroy($seanceIds);
    }

    /**
     * Deletes a seance with related tickets
     */
    public function deleteSeance($seanceId)
    {
        DB::beginTransaction();

        try {
            // Find related tickets
            $relatedTicketIds = $this->ticketRepository->findTickets('seanceId', $seanceId)
                ->map(function ($ticket) {
                    return $ticket->id;
                })->all();

            // Delete tickets
            $this->ticketRepository->deleteTickets($relatedTicketIds);
            // Delete seance
            Seance::destroy($seanceId);

        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            DB::rollBack();
            return 0;
        } //TODO:: Add custom Exception
        DB::commit();
        return 1;
    }
}
