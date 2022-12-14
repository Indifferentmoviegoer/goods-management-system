<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Product;
use App\Tests\Common\WebTestCase;

class ProductRepositoryTest extends WebTestCase
{
    public function testRemove()
    {
        $productRepository = $this->getProductRepository();

        $product = new Product();
        $product
            ->setName('example')
            ->setDescription('example')
            ->setWeight('20 g');

        $productRepository->save($product, true);

        $product = $productRepository->findOneByName('example');
        $this->assertEquals('example', $product->getName());
        $this->assertEquals('example', $product->getDescription());
        $this->assertEquals('20 g', $product->getWeight());

        $productRepository->remove($product, true);
        $this->assertEquals([], $productRepository->findAll());
    }
}
