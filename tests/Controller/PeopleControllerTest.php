<?php

namespace App\Tests\Controller;

use App\Repository\PeopleRepository;
use App\Tests\AbstractTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

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
}