<?php

namespace App\Interfaces;

interface SeanceRepositoryInterface {
    public function getAllSeances();
    public function createSeance($seanceData);
    public function findSeances($key, $value);
    public function deleteSeances(array $seanceIds);
    public function deleteSeance($seanceId);
};
