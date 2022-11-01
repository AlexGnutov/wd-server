<?php

namespace App\Repositories;

use App\Exceptions\CustomDatabaseException;
use App\Interfaces\FilmRepositoryInterface;
use App\Interfaces\SeanceRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Film;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FilmRepository implements FilmRepositoryInterface {

    private SeanceRepositoryInterface $seanceRepository;
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        SeanceRepositoryInterface $seanceRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->seanceRepository = $seanceRepository;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @throws CustomDatabaseException
     */
    public function getAllFilms(): Collection
    {
        try {
            return Film::all();
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function createFilm($filmData)
    {
        try {
            return Film::create($filmData);
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function deleteFilm($filmId): int
    {
        try {
            DB::beginTransaction();

            // Collect all seances related to the film, and get their IDs
            $relatedSeanceIds = $this->seanceRepository->findSeances('filmId', $filmId)
                ->map(function ($seance) {
                    return $seance->id;
                })->all();

            // Collect all tickets related to the film, and get their IDs
            $relatedTicketIds = [];
            foreach ($relatedSeanceIds as $seanceId) {
                $tickets = $this->ticketRepository->findTickets('seanceId', $seanceId )
                    ->map(function ($ticket) {
                        return $ticket->id;
                    })->all();
                array_push($relatedTicketIds, ...$tickets);
            }

            // Delete tickets
            $this->ticketRepository->deleteTickets($relatedTicketIds);
            // Delete seances
            $this->seanceRepository->deleteSeances($relatedSeanceIds);

            // Delete film
            $result = Film::destroy([$filmId]);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CustomDatabaseException($exception->getMessage());
        }
    }
}
