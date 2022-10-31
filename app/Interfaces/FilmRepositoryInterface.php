<?php

namespace App\Interfaces;

interface FilmRepositoryInterface {
    public function getAllFilms();
    public function createFilm($filmData);
    public function deleteFilm($filmId);
};
