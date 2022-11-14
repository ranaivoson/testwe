<?php

namespace App\Tests\Controller;

use App\Repository\MovieRepository;
use App\Tests\AbstractTestCase;
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
}