<?php

namespace App\Repositories;

use App\Exceptions\CustomDatabaseException;
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

    /**
     * @throws CustomDatabaseException
     */
    public function getAllSeances(): Collection|\Illuminate\Support\Collection
    {
        try {
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
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }

    }

    /**
     * @throws CustomDatabaseException
     */
    public function createSeance($seanceData)
    {
        try {
            return Seance::create($seanceData);
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function findSeances($key, $value): Collection
    {
        try {
            return Seance::where($key, '=', $value)->get();
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * Deletes seances only
     * @param array $seanceIds
     * @return int
     * @throws CustomDatabaseException
     */
    public function deleteSeances(array $seanceIds): int
    {
        try {
            return Seance::destroy($seanceIds);
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * Deletes a seance with related tickets
     * @throws CustomDatabaseException
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
            $result = Seance::destroy($seanceId);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CustomDatabaseException($exception->getMessage());
        }
    }
}
