<?php

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/people', name: 'post_people', methods: 'POST')]
    #[IsGranted('ROLE_USER')]
    public function postMovie(
        Request             $request,
        PeopleRepository    $peopleRepository,
        SerializerInterface $serializer
    ): JsonResponse
    {
        $people = $serializer->deserialize($request->getContent(), People::class, 'json');
        $peopleRepository->save($people, true);
        return $this->json($people, Response::HTTP_CREATED);
    }
}