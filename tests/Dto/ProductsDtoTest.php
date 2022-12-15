<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\ProductDto;
use App\Dto\ProductsDto;
use App\Tests\Common\WebTestCase;

class ProductsDtoTest extends WebTestCase
{
    public function testAddProduct(): void
    {
        $productsDto = new ProductsDto();

        $this->assertEquals(null, $productsDto->getProduct());

        $productsDto->addProduct(new ProductDto());

        $this->assertCount(1, $productsDto->getProduct());
    }
}
