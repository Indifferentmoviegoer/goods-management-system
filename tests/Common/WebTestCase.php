<?php

declare(strict_types=1);

namespace App\Tests\Common;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Helper\FileHelper;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    private const FILE_RELATIVE_PATH = 'tests/Common/import.xml';
    private const COPY_FILE_RELATIVE_PATH = 'public/uploads/import.xml';

    protected function getXmlFilePath(): string
    {
        return sprintf('%s/%s', dirname(__DIR__, 2), self::FILE_RELATIVE_PATH);
    }

    protected function getXmlCopyFilePath(): string
    {
        return sprintf('%s/%s', dirname(__DIR__, 2), self::COPY_FILE_RELATIVE_PATH);
    }

    protected function getEntityManager(): Registry
    {
        return $this->getContainer()->get(ManagerRegistry::class);
    }

    protected function getProductRepository(): ProductRepository
    {
        return $this->getEntityManager()->getRepository(Product::class);
    }

    protected function getProductCategoryRepository(): ProductCategoryRepository
    {
        return $this->getEntityManager()->getRepository(ProductCategory::class);
    }

    protected function getFileHelper(): FileHelper
    {
        return $this->getContainer()->get(FileHelper::class);
    }
}