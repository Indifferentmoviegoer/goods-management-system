<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\ProductCategory;
use App\Tests\Common\WebTestCase;

class ProductCategoryRepositoryTest extends WebTestCase
{
    public function testRemove()
    {
        $productCategoryRepository = $this->getProductCategoryRepository();

        $productCategory = new ProductCategory();
        $productCategory->setTitle('example');
        $productCategoryRepository->save($productCategory, true);

        $productCategory = $productCategoryRepository->findOneByTitle('example');
        $this->assertEquals('example', $productCategory->getTitle());

        $productCategoryRepository->remove($productCategory, true);
        $this->assertEquals([], $productCategoryRepository->findAll());
    }
}
