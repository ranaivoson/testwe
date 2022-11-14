<?php

namespace App\Api;

use App\Entity\Movie;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RapidApiMovie implements ApiMovieInterface
{
    public const URL = 'https://imdb8.p.rapidapi.com';

    public function __construct(
        private string $xkey,
        private string $host,
        private readonly HttpClientInterface $httpClient,
        private readonly CacheInterface $cache
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getMovieUrl(Movie $movie): string
    {
        return $this->cache->get(md5($movie->getTitle()), function () use ($movie){
            $response = $this->httpClient->request('GET', self::URL. '/title/find', [
                'query' => [
                    'q' => $movie->getTitle()
                ],
                'headers' => [
                    'X-RapidAPI-Key' => '754237601amsh09f935cdb5ffcbfp1d2043jsn05080faa1d70',
                    'X-RapidAPI-Host' => 'imdb8.p.rapidapi.com'
                ],
            ]);

            $results = $response->toArray()['results'];
            return $results[0]['image']['url'] ?? '';
        });
    }
}