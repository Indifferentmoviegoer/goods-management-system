<?php

declare(strict_types=1);

namespace App\Tests\Service\Product\Messenger;

use App\Service\Parser\ProductParser;
use App\Service\Product\Messenger\ProductImportMessage;
use App\Service\Product\Messenger\ProductImportMessageHandler;
use App\Tests\Common\WebTestCase;
use Exception;

class ProductImportMessageHandlerTest extends WebTestCase
{
    public function test__invoke(): void
    {
        $productImportMessage = new ProductImportMessage($this->getXmlFilePath());
        $productImportMessageHandler = $this->getProductImportMessageHandler();

        $this->assertEquals(true, $productImportMessageHandler->__invoke($productImportMessage));
    }

    public function testFailed__invoke(): void
    {
        $productImportMessage = new ProductImportMessage($this->getXmlFilePath());

        $productParser = $this->createMock(ProductParser::class);
        $productParser
            ->method('parserXml')
            ->willThrowException(new Exception);

        $productImportMessageHandler = new ProductImportMessageHandler($productParser, $this->getLoggerInterface());

        $this->assertEquals(false, $productImportMessageHandler->__invoke($productImportMessage));
    }
}
