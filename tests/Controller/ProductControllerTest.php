<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Common\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $xmlFile = new UploadedFile(
            $this->getXmlFilePath(), 'import.xml', 'application/xml', null, true
        );

        $client = $this->createClient();
        $response = $this->jsonRequest($client, self::METHOD_POST, '/import', ['upload_file' => $xmlFile]);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
