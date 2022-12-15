<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Tests\Common\WebTestCase;

class ProductRepositoryTest extends WebTestCase
{
    public function testRemove(): void
    {
        $this->createProduct();

        $productRepository = $this->getProductRepository();
        $product = $productRepository->findOneByName('example');

        $this->assertEquals('example', $product->getName());
        $this->assertEquals('example', $product->getDescription());
        $this->assertEquals('20 g', $product->getWeight());

        $productRepository->remove($product, true);

        $this->assertEquals([], $productRepository->findAll());
    }
}
