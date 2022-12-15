<?php

declare(strict_types=1);

namespace App\Tests\Service\Product;

use App\Service\Product\Messenger\ProductImportMessage;
use App\Service\Product\ProductService;
use App\Tests\Common\WebTestCase;

class ProductServiceTest extends WebTestCase
{
    public function testImportFromXml(): void
    {
        $productService = $this->getContainer()->get(ProductService::class);
        $envelope = $productService->importFromXml($this->getXmlFilePath());

        $this->assertInstanceOf(ProductImportMessage::class, $envelope->getMessage());
    }
}
