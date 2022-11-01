<?php

namespace App\Repositories;

use App\Exceptions\CustomDatabaseException;
use App\Interfaces\TicketRepositoryInterface;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface {

    /**
     * @throws CustomDatabaseException
     */
    public function getTickets($ticketDetails)
    {
        try {
            $date = $ticketDetails['date'];
            $seance = $ticketDetails['seance'];
            return Ticket::where('date', '=', $date)
                ->where('seanceId', '=', $seance)->get();
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function createTicket($ticketData)
    {
        try {
            $ticket = Ticket::create([
                'date' => $ticketData['date'],
                'seanceId' => $ticketData['seanceId'],
                'seats' => $ticketData['seats'],
            ]);

            $seance = Seance::where('id', '=', $ticket->seanceId)->first();
            $hall = Hall::where('id', '=', $seance->hallId)->first();
            $film = Film::where('id', '=', $seance->filmId)->first();

            return [
                'seanceId' => $ticket->seanceId,
                'hallTitle' => $hall->title,
                'filmTitle' => $film->title,
                'seats' => $ticket->seats,
                'startTime' => $seance->startTime,
            ];
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function findTickets($key, $value) {
        try {
            return Ticket::where($key, '=', $value)->get();
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }

    /**
     * @throws CustomDatabaseException
     */
    public function deleteTickets(array $ticketIds): int
    {
        try {
            return Ticket::destroy($ticketIds);
        } catch (\Exception $exception) {
            throw new CustomDatabaseException($exception->getMessage());
        }
    }
}
