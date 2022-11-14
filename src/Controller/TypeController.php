<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController
{
    #[Route('/types', name: 'get_types', methods: 'GET')]
    public function getTypes(TypeRepository $typeRepository): JsonResponse
    {
        return $this->json($typeRepository->findAll());
    }

    #[Route('/types/{id}', name: 'get_type', methods: 'GET')]
    public function getType(TypeRepository $typeRepository, int $id): JsonResponse
    {
        $type = $typeRepository->find($id);
        if (!$type){
            return $this->json(['message' => "Type not found"], 404);
        }
        return $this->json($type);
    }
}