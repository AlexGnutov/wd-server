<?php

namespace App\Repositories;

use App\Interfaces\TicketRepositoryInterface;
use App\Models\Film;
use App\Models\Hall;
use App\Models\Seance;
use App\Models\Ticket;

class TicketRepository implements TicketRepositoryInterface {

    public function getTickets($ticketDetails)
    {
        $date = $ticketDetails['date'];
        $seance = $ticketDetails['seance'];

        return Ticket::where('date', '=', $date)
            ->where('seanceId', '=', $seance)->get();
    }

    public function createTicket($ticketData)
    {
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
    }

    public function findTickets($key, $value) {
        return Ticket::where($key, '=', $value)->get();
    }

    public function deleteTickets(array $ticketIds): int
    {
        return Ticket::destroy($ticketIds);
    }


}
