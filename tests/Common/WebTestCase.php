<?php

declare(strict_types=1);

namespace App\Tests\Common;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Helper\FileHelper;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Product\Messenger\ProductImportMessageHandler;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class WebTestCase extends ApiTestCase
{
    protected const METHOD_POST = 'POST';
    protected const METHOD_GET = 'GET';
    protected const METHOD_PATCH = 'PATCH';
    protected const METHOD_DELETE = 'DELETE';

    protected const EXAMPLE_TEXT = 'example';

    private const FILE_RELATIVE_PATH = 'tests/Common/import.xml';
    private const COPY_FILE_RELATIVE_PATH = 'public/uploads/import.xml';

    public static function getXmlFilePath(): string
    {
        return sprintf('%s/%s', dirname(__DIR__, 2), self::FILE_RELATIVE_PATH);
    }

    public static function getXmlCopyFilePath(): string
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

    protected function getProductImportMessageHandler(): ProductImportMessageHandler
    {
        return $this->getContainer()->get(ProductImportMessageHandler::class);
    }

    protected function getLoggerInterface(): LoggerInterface
    {
        return $this->getContainer()->get(LoggerInterface::class);
    }

    protected function createProduct(): Product
    {
        $product = new Product();
        $product
            ->setName(self::EXAMPLE_TEXT)
            ->setDescription(self::EXAMPLE_TEXT)
            ->setWeight('20 g');

        $this->getProductRepository()->save($product, true);

        return $product;
    }

    protected function addCategory(Product $product, ProductCategory $productCategory): Product
    {
        $product->addCategory($productCategory);

        $this->getProductRepository()->save($product, true);

        return $product;
    }

    protected function createProductCategory(): ProductCategory
    {
        $productCategory = new ProductCategory();
        $productCategory->setTitle(self::EXAMPLE_TEXT);

        $this->getProductCategoryRepository()->save($productCategory, true);

        return $productCategory;
    }

    protected function addProduct(ProductCategory $productCategory, Product $product): ProductCategory
    {
        $productCategory->addProduct($product);

        $this->getProductCategoryRepository()->save($productCategory, true);

        return $productCategory;
    }
}