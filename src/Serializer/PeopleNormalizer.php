<?php

namespace App\Serializer;

use App\Entity\People;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PeopleNormalizer implements NormalizerInterface
{
    public function __construct(
        private readonly ObjectNormalizer      $normalizer,
    )
    {
    }

    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof People;
    }
}