<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PeopleController extends AbstractController
{
    #[Route('/people', name: 'get_people', methods: "GET")]
    public function getPeople(PeopleRepository $peopleRepository): JsonResponse
    {
        return $this->json($peopleRepository->findAll());
    }

    #[Route('/people/{id}', name: 'get_person', methods: "GET")]
    public function getPerson(People $people): JsonResponse
    {
        return $this->json($people);
    }

    #[Route('/people/{id}/movies', name: 'get_movies_by_person', methods: "GET")]
    public function getPersonMovies(People $people): JsonResponse
    {
        return $this->json($people->getMovieHasPeople());
    }
}