<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface TicketRepositoryInterface {
    public function getTickets(array $ticketDetails): Collection;
    public function createTicket(array $ticketData): array;
    public function findTickets(string $key, string $value): Collection;
    public function deleteTickets(array $ticketIds): int;
};
