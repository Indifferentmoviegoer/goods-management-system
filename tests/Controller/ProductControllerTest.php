<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Common\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testGetIndex(): void
    {
        $client = static::createClient();
        $response = $client->request(self::METHOD_GET, '/import');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testPostIndex(): void
    {
        $this->assertTrue(true);
    }
}
