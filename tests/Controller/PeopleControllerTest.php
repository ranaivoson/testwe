<?php

namespace App\Tests\Controller;

use App\Repository\PeopleRepository;
use App\Tests\AbstractTestCase;
use Exception;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use JsonException;

class PeopleControllerTest extends AbstractTestCase
{
    use RefreshDatabaseTrait;

    public function testGetAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/people');
        self::assertResponseIsSuccessful();
    }

    public function testGetOneMovie(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $people = $container->get(PeopleRepository::class)->findOneBy([]);
        $client->request('GET', '/people/'. $people->getId());
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws Exception
     */
    public function testGetMovieByPeople():void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $people = $container->get(PeopleRepository::class)->findOneBy([]);

        $client->request('GET', '/people/'. $people->getId() . '/movies');
        self::assertResponseIsSuccessful();
    }

    /**
     * @throws JsonException
     */
    public function testCreateMovieValid(): void
    {

        $client = $this->getConnectedClient();
        $client->request('POST', '/people', [],[], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstname' => 'fidy',
                'lastname' => 'ranaivoson',
                'dateOfBirth' => '1989-03-10',
                'nationality' => 'malgache'
            ], JSON_THROW_ON_ERROR)
        );
        self::assertResponseStatusCodeSame(201);

        $content = $client->getResponse()->getContent();
        $array = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        self::assertSame($array['firstname'], 'fidy');
        self::assertSame($array['lastname'], 'ranaivoson');
        self::assertSame($array['nationality'], 'malgache');
        self::assertSame($array['dateOfBirth'], '1989-03-10T00:00:00+00:00');
        self::assertArrayHasKey('id', $array);
    }
}