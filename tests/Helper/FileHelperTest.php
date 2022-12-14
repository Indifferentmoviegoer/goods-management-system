<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Tests\Common\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelperTest extends WebTestCase
{
    public function testGetPublicDir()
    {
        self::assertEquals('/var/www/symfony/public', $this->getFileHelper()->getPublicDir());
    }

    public function testGetUploadsDirectory()
    {
        self::assertEquals('/var/www/symfony/public/uploads', $this->getFileHelper()->getUploadsDirectory());
    }

    public function testUpload()
    {
        $xmlFile = new UploadedFile(
            $this->getXmlFilePath(), 'import.xml', 'application/xml', null, true
        );

        copy($this->getXmlFilePath(), $this->getXmlCopyFilePath());

        $this->assertEquals(true, (bool)$this->getFileHelper()->upload($xmlFile));

        copy($this->getXmlCopyFilePath(), $this->getXmlFilePath());
    }
}
