<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\ProductDto;
use App\Tests\Common\WebTestCase;

class ProductDtoTest extends WebTestCase
{
    public function testSetName(): void
    {
        $productDto = new ProductDto();
        $productDto->setName(self::EXAMPLE_TEXT);

        $this->assertEquals(self::EXAMPLE_TEXT, $productDto->getName());
    }

    public function testSetDescription(): void
    {
        $productDto = new ProductDto();
        $productDto->setDescription(self::EXAMPLE_TEXT);

        $this->assertEquals(self::EXAMPLE_TEXT, $productDto->getDescription());
    }

    public function testSetWeight(): void
    {
        $productDto = new ProductDto();
        $productDto->setWeight(self::EXAMPLE_TEXT);

        $this->assertEquals(self::EXAMPLE_TEXT, $productDto->getWeight());
    }

    public function testSetCategory(): void
    {
        $productDto = new ProductDto();
        $productDto->setCategory(self::EXAMPLE_TEXT);

        $this->assertEquals(self::EXAMPLE_TEXT, $productDto->getCategory());
    }
}
