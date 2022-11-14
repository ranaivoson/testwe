<?php

namespace App\Tests\Controller;

use App\Repository\MovieRepository;
use App\Repository\PeopleRepository;
use App\Tests\AbstractTestCase;
use Exception;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use JsonException;

class MovieControllerTest extends AbstractTestCase
{
    use RefreshDatabaseTrait;

    public function testGetAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movies');
        self::assertResponseIsSuccessful();
    }

    public function testGetOneMovie(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $movie = $container->get(MovieRepository::class)->findOneBy([]);
        $client->request('GET', '/movies/'. $movie->getId());
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws Exception
     */
    public function testGetPeopleByMovie():void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $movie = $container->get(MovieRepository::class)->findOneBy([]);

        $client->request('GET', '/movies/'. $movie->getId() . '/people');
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws JsonException
     */
    public function testCreateMovieDenied(): void
    {
        $client = static::createClient();
        $client->request('POST', '/movies', [],[], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'title' => 'test create',
                'duration' => 145
            ], JSON_THROW_ON_ERROR)
        );
        self::assertResponseStatusCodeSame(401);
    }

    /**
     * @throws JsonException
     */
    public function testCreateMovieValid(): void
    {
        $client = $this->getConnectedClient();
        $client->request('POST', '/movies', [],[], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'title' => 'test create',
                'duration' => 145
            ], JSON_THROW_ON_ERROR)
        );

        $content = $client->getResponse()->getContent();
        $array = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertResponseStatusCodeSame(201);
        self::assertSame($array['title'], 'test create');
        self::assertSame($array['duration'], 145);
        self::assertArrayHasKey('id', $array);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function testAddPeopleToMovie(): void
    {
        $client = $this->getConnectedClient();
        $container = static::getContainer();

        $movie = $container->get(MovieRepository::class)->findOneBy([]);
        $people = $container->get(PeopleRepository::class)->findOneBy([]);

        $client->request('PUT', '/movies/'. $movie->getId(). '/people/'. $people->getId(),
            [],[], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'role' => 'actrice',
                'significance' => 'principal'
            ], JSON_THROW_ON_ERROR)
        );
        self::assertResponseIsSuccessful();
    }
}