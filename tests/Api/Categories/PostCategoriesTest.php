<?php

declare(strict_types=1);

namespace Tests\Api\Users;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostCategoriesTest extends WebTestCase
{
    public function testPostCategorySucess()
    {
        $client = static::createClient();
        
        $client->request(
            'POST',
            '/categories',
            [],
            [],
            [
                'Content-Type' => 'application/json'
            ],
            \json_encode([
                'name' => 'Ropa'
            ])
        );
        
        $arrayResponse = \json_decode($client->getResponse()->getContent(), true);
        
        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }
}
