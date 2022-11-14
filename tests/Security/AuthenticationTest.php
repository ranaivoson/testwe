<?php

namespace App\Tests\Security;

use App\Tests\AbstractTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use JsonException;

class AuthenticationTest extends AbstractTestCase
{
    use RefreshDatabaseTrait;


    /**
     * @throws JsonException
     */
    public function testLogin(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/authentication_token',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'admin@example.com',
                'password' => 'password',
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertNotNull($data['token']);
    }
}