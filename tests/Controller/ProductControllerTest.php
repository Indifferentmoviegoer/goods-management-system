<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Common\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testGetIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/import');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPostIndex(): void
    {
        copy(WebTestCase::getXmlFilePath(), WebTestCase::getXmlCopyFilePath());

        $xmlFile = new UploadedFile(
            WebTestCase::getXmlFilePath(), 'import.xml', 'application/xml', null, true
        );

        $client = static::createClient();
        $client->request(
            'POST', '/import',
            [
                'headers' => ['Content-Type' => 'multipart/form-data'],
            ],
            [
                'file_upload' => [
                    'upload_file' => $xmlFile,
                ]
            ]
        );

        copy(WebTestCase::getXmlCopyFilePath(), WebTestCase::getXmlFilePath());

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
