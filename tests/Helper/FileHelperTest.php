<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Tests\Common\WebTestCase;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileHelperTest extends WebTestCase
{
    public function testGetPublicDir(): void
    {
        $this->assertEquals('/var/www/symfony/public', $this->getFileHelper()->getPublicDir());
    }

    public function testGetUploadsDirectory(): void
    {
        $this->assertEquals('/var/www/symfony/public/uploads', $this->getFileHelper()->getUploadsDirectory());
    }

    public function testUpload(): void
    {
        $xmlFile = new UploadedFile(
            $this->getXmlFilePath(), 'import.xml', 'application/xml', null, true
        );

        copy($this->getXmlFilePath(), $this->getXmlCopyFilePath());

        $this->assertEquals(true, (bool)$this->getFileHelper()->upload($xmlFile));

        copy($this->getXmlCopyFilePath(), $this->getXmlFilePath());
    }

    public function testFailedUpload(): void
    {
        $xmlFile = $this->createMock(UploadedFile::class);
        $xmlFile
            ->method('move')
            ->willThrowException(new FileException());

        $this->assertEquals(null, $this->getFileHelper()->upload($xmlFile));
    }
}
