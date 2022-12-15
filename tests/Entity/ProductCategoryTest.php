<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Tests\Common\WebTestCase;

class ProductCategoryTest extends WebTestCase
{
    public function testGetId(): void
    {
        $this->assertEquals(1, $this->createProductCategory()->getId());
    }

    public function testRemoveProduct(): void
    {
        $product = $this->createProduct();
        $productCategory = $this->createProductCategory();

        $this->addProduct($productCategory, $product);
        $this->assertEquals(self::EXAMPLE_TEXT, $productCategory->getProducts()->getValues()[0]->getName());

        $productCategory->removeProduct($product);
        $this->assertEquals([], $productCategory->getProducts()->getValues());
    }

    public function test__toString(): void
    {
        $this->assertEquals(self::EXAMPLE_TEXT, $this->createProductCategory()->__toString());
    }
}
