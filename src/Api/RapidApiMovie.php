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
        private readonly string              $xKey,
        private readonly string              $host,
        private readonly HttpClientInterface $httpClient,
        private readonly CacheInterface      $cache
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
                    'X-RapidAPI-Key' => $this->xKey,
                    'X-RapidAPI-Host' => $this->host
                ],
            ]);

            $results = $response->toArray()['results'];
            return $results[0]['image']['url'] ?? '';
        });
    }
}