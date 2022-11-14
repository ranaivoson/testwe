<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\MovieHasPeople;
use App\Entity\People;
use App\Repository\MovieHasPeopleRepository;
use App\Repository\MovieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


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

    #[Route('/movies', name: 'post_movie', methods: 'POST')]
    #[IsGranted('ROLE_USER')]
    public function postMovie(
        Request $request,
        MovieRepository $movieRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $movie = $serializer->deserialize($request->getContent(), Movie::class, 'json');
        $movieRepository->save($movie, true);
        return $this->json($movie, Response::HTTP_CREATED);
    }


    #[Route('/movies/{movie_id}/people/{people_id}', name: 'put_people', methods: "PUT")]
    #[Entity('movie', options: ['id'=> 'movie_id'])]
    #[Entity('people', options: ['id'=> 'people_id'])]
    #[IsGranted('ROLE_USER')]
    public function addPeopleToMovie(
        Request $request,
        SerializerInterface $serializer,
        MovieHasPeopleRepository $movieHasPeopleRepository,
        Movie $movie, People $people
    ): JsonResponse
    {
        $movieHasPeople = $serializer->deserialize($request->getContent(), MovieHasPeople::class, 'json');
        $movieHasPeople->setMovie($movie);
        $movieHasPeople->setPeople($people);
        $movieHasPeopleRepository->save($movieHasPeople, true);
        return $this->json([]);
    }
}