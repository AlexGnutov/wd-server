<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface FilmRepositoryInterface {
    public function getAllFilms(): Collection;
    public function createFilm(array $filmData, $imageFile): Model;
    public function deleteFilm(string $filmId): int;
};
