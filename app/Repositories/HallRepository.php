<?php

namespace App\Repositories;

use App\Interfaces\HallRepositoryInterface;
use App\Interfaces\SeanceRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class HallRepository implements HallRepositoryInterface {

    private SeanceRepositoryInterface $seanceRepository;
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        SeanceRepositoryInterface $seanceRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->seanceRepository = $seanceRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function getAllHalls(): Collection
    {
        return Hall::all();
    }

    public function createHall($hallData)
    {
        return Hall::create($hallData);
    }

    public function updateHall($hallId, $updateHallData)
    {
        $hall = Hall::findOrFail($hallId);
        $hall->fill($updateHallData);
        $hall->save();
        return $hall;
    }

    public function deleteHall($hallId): int
    {
        DB::beginTransaction();
        try {
            // Collect seances in to be deleted hall, and get their IDs
            $relatedSeanceIds = $this->seanceRepository->findSeances('hallId', $hallId)
                ->map(function ($seance) {
                    return $seance->id;
                })->all();

            // Collect all tickets related to the seances
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
            // Delete hall
            Hall::destroy([$hallId]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            DB::rollBack();
            return 0;
        } // TODO: ADD Custom Exception
        DB::commit();
        return 1;
    }
}
