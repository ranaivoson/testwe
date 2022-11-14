<?php

namespace App\Tests\Controller;

use App\Repository\MovieRepository;
use App\Repository\PeopleRepository;
use App\Tests\AbstractTestCase;
use Exception;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

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
}