<?php

namespace App\Interfaces;

interface HallRepositoryInterface
{
    public function getAllHalls();
    public function createHall($hallData);
    public function updateHall($hallId, $updateHallData);
    public function deleteHall($hallId);
};
