<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Tests\Common\WebTestCase;

class ProductCategoryRepositoryTest extends WebTestCase
{
    public function testRemove(): void
    {
        $this->createProductCategory();

        $productCategoryRepository = $this->getProductCategoryRepository();
        $productCategory = $productCategoryRepository->findOneByTitle('example');

        $this->assertEquals('example', $productCategory->getTitle());

        $productCategoryRepository->remove($productCategory, true);

        $this->assertEquals([], $productCategoryRepository->findAll());
    }
}
