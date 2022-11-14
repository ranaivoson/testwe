<?php

namespace App\Serializer;

use App\API\ApiInterface;
use App\Entity\Movie;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MovieNormalizer implements NormalizerInterface
{

    public function __construct(
        private UrlGeneratorInterface $router,
        private ObjectNormalizer      $normalizer,
    )
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['people'] = $this->router->generate('get_people_by_movie', [
            'id' => $object->getId()
        ]);

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Movie;
    }
}