<?php

namespace App\Serializer;

use App\Api\ApiMovieInterface;
use App\Api\RapidApiMovie;
use App\Entity\Movie;
use App\Entity\Type;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class MovieNormalizer implements NormalizerInterface
{

    public function __construct(
        private readonly UrlGeneratorInterface $router,
        private readonly ObjectNormalizer      $normalizer,
        private readonly RapidApiMovie $apiMovie
    )
    {
    }

    /**
     * @throws ExceptionInterface
     * @throws InvalidArgumentException
     */
    public function normalize(mixed $object, string $format = null, array $context = [])
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        $data['people'] = $this->router->generate('get_people_by_movie', [
            'id' => $object->getId()
        ]);

        /** @var Type $type */
        foreach ($object->getTypes() as $type) {
            $data['types'][] = $this->router->generate('get_type', [
                'id' => $type->getId()
            ]);
        }

        $data['url'] = $this->apiMovie->getMovieUrl($object);

        return $data;
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof Movie;
    }
}