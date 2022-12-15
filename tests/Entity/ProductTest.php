<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Tests\Common\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testGetId(): void
    {
        $this->assertEquals(2, $this->createProduct()->getId());
    }

    public function testRemoveCategory(): void
    {
        $product = $this->createProduct();
        $productCategory = $this->createProductCategory();

        $this->addCategory($product, $productCategory);
        $this->assertEquals(self::EXAMPLE_TEXT, $product->getCategories()->getValues()[0]->getTitle());

        $product->removeCategory($productCategory);
        $this->assertEquals([], $product->getCategories()->getValues());
    }

    public function test__toString(): void
    {
        $this->assertEquals(self::EXAMPLE_TEXT, $this->createProduct()->__toString());
    }
}
