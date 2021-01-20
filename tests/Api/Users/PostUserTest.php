<?php

declare(strict_types=1);

namespace Tests\Api\Users;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostUserTest extends WebTestCase
{
    public function testPostUserSucess()
    {
        $client = static::createClient();
        
        $client->request(
            'POST',
            '/users',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibal@w3itsolutions.org',
                'password' => '654321'
            ])
        );
        
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            [
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibal@w3itsolutions.org'
            ],
            \json_decode($client->getResponse()->getContent(), true)
        );
    }
    
    public function testPostUserErrorBadEmail()
    {
        $client = static::createClient();
        
        $client->request(
            'POST',
            '/users',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibalw3itsolutions.org',
                'password' => '654321'
            ])
        );
        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('email', \json_decode($client->getResponse()->getContent(), true)['errors']);
        
    }
    
    public function testPostUserErrorEmptyData()
    {
        $client = static::createClient();
        
        $client->request(
            'POST',
            '/users',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([])
        );
        
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('username', \json_decode($client->getResponse()->getContent(), true)['errors']);
        $this->assertArrayHasKey('email', \json_decode($client->getResponse()->getContent(), true)['errors']);
        $this->assertArrayHasKey('password', \json_decode($client->getResponse()->getContent(), true)['errors']);
    }
    
    public function testPostUserErrorDuplicated()
    {
        $client = static::createClient();
        
        $client->request(
            'POST',
            '/users',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibal@w3itsolutions.org',
                'password' => '654321'
            ])
        );
        
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        
        $client->request(
            'POST',
            '/users',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([
                'username' => 'anibal@w3itsolutions.org',
                'email' => 'anibal@w3itsolutions.org',
                'password' => '654321'
            ])
        );
        
        var_dump($client->getResponse()->getContent());
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
