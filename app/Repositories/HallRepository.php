<?php

namespace App\Repositories;

use App\Exceptions\CustomDatabaseException;
use App\Interfaces\HallRepositoryInterface;
use App\Interfaces\SeanceRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class HallRepository implements HallRepositoryInterface
{

    private SeanceRepositoryInterface $seanceRepository;
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        SeanceRepositoryInterface $seanceRepository,
        TicketRepositoryInterface $ticketRepository
    )
    {
        $this->seanceRepository = $seanceRepository;
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @throws CustomDatabaseException
     */
    public function getAllHalls(): Collection
    {
        try {
            return Hall::all();
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function createHall($hallData)
    {
        try {
            return Hall::create($hallData);
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function updateHall($hallId, $updateHallData)
    {
        try {
            $hall = Hall::findOrFail($hallId);
            $hall->fill($updateHallData);
            $hall->save();
            return $hall;
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }

    }

    /**
     * @throws CustomDatabaseException
     */
    public function deleteHall($hallId): int
    {
        try {
            DB::beginTransaction();

            // Collect seances in to be deleted hall, and get their IDs
            $relatedSeanceIds = $this->seanceRepository->findSeances('hallId', $hallId)
                ->map(function ($seance) {
                    return $seance->id;
                })->all();

            // Collect all tickets related to the seances
            $relatedTicketIds = [];
            foreach ($relatedSeanceIds as $seanceId) {
                $tickets = $this->ticketRepository->findTickets('seanceId', $seanceId)
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
            $result = Hall::destroy([$hallId]);
            DB::commit();
            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new CustomDatabaseException($exception->getMessage());
        }
    }
}
