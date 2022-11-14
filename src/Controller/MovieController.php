<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class MovieController extends AbstractController
{
    #[Route('/movies', name: 'get_movies', methods: "GET")]
    public function getMovies(MovieRepository $movieRepository): JsonResponse
    {
        return $this->json($movieRepository->findAll());
    }

    #[Route('/movies/{id}', name: 'get_movie', methods: "GET")]
    public function getMovie(MovieRepository $movieRepository, int $id): JsonResponse
    {
        $movie = $movieRepository->find($id);
        if (!$movie){
            return $this->json(['message' => "Movie not found"], 404);
        }
        return $this->json($movie);
    }

    #[Route('/movies/{id}/people', name: 'get_people_by_movie')]
    public function getPeopleByMovie(MovieRepository $movieRepository, int $id): JsonResponse
    {
        $movie = $movieRepository->find($id);
        if (!$movie){
            return $this->json(['message' => "Movie not found"], 404);
        }
        return $this->json($movie->getMovieHasPeople());
    }
}