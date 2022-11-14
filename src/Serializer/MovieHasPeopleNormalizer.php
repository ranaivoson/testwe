<?php

namespace App\Serializer;

use App\Entity\MovieHasPeople;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MovieHasPeopleNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
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

        $data['person'] = $this->router->generate('get_person', [
            'id' => $object->getPeople()->getId()
        ]);
        $data['movie'] = $this->router->generate('get_movie', [
            'id' => $object->getMovie()->getId()
        ]);

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof MovieHasPeople;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }
}