<?php

namespace App\Interfaces;

interface TicketRepositoryInterface {
    public function getTickets($ticketDetails);
    public function createTicket($ticketData);
    public function findTickets($key, $value);
    public function deleteTickets(array $ticketIds): int;
};
