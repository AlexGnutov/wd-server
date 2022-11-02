<?php

namespace App\Interfaces;

interface FilmRepositoryInterface {
    public function getAllFilms();
    public function getPaginatedFilms();
    public function createFilm($filmData, $imageFile);
    public function deleteFilm($filmId);
};
