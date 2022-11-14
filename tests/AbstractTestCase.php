<?php

namespace App\Tests;

use Hautelook\AliceBundle\PhpUnit\RecreateDatabaseTrait;
use JsonException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractTestCase extends WebTestCase
{
    use RecreateDatabaseTrait;

    /**
     * @throws JsonException
     */
    protected function getConnectedClient(
        string $username = 'admin@example.com',
        string $password = 'password'
    ): KernelBrowser
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/authentication_token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => $username,
                'password' => $password,
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}