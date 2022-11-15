<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface HallRepositoryInterface
{
    public function getAllHalls(): Collection;
    public function createHall(array $hallData): Model;
    public function updateHall(string $hallId, array $updateHallData): Model;
    public function deleteHall(string $hallId): int;
};
