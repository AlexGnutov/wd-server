<?php

namespace App\Repositories;

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

    public function getAllFilms(): Collection
    {
        return Film::all();
    }

    public function createFilm($filmData)
    {
        return Film::create($filmData);
    }

    public function deleteFilm($filmId): int
    {
        DB::beginTransaction();
        try {
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
            Film::destroy([$filmId]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            DB::rollBack();
            return 0;
        } // TODO: ADD Custom Exception
        DB::commit();
        return 1;
    }
}
