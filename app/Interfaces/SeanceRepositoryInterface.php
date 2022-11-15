<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Collection;

interface SeanceRepositoryInterface {
    public function getAllSeances(): Collection;
    public function createSeance(array $seanceData): Model;
    public function findSeances(string $key, string $value): Collection;
    public function deleteSeances(array $seanceIds): int;
    public function deleteSeance(string $seanceId): int;
};
