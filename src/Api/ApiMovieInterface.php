<?php

namespace App\Api;

use App\Entity\Movie;

interface ApiMovieInterface
{
    public function getMovieUrl(Movie $movie): string;
}