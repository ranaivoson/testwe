<?php

namespace App\Serializer;

use App\Entity\People;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PeopleNormalizer implements NormalizerInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly ObjectNormalizer      $normalizer,
    )
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['movies'] = $this->router->generate('get_movies_by_person', [
            'id' => $object->getId()
        ]);

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof People;
    }
}