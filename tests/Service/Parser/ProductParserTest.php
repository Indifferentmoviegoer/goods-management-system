<?php

declare(strict_types=1);

namespace App\Tests\Service\Parser;

use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use App\Service\Parser\ProductParser;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductParserTest extends WebTestCase
{
    private const FILE_RELATIVE_PATH = 'import.xml';

    public function testParserXml()
    {
        $filePath = sprintf('%s/%s', dirname(__DIR__, 2), self::FILE_RELATIVE_PATH);

        $productParser = $this->getContainer()->get(ProductParser::class);
        $productParser->parserXml($filePath);

        $doctrine = $this->getContainer()->get(ManagerRegistry::class);

        /** @var ProductRepository $productRepository */
        $productRepository = $doctrine->getRepository(Product::class);
        /** @var ProductCategoryRepository $productCategoryRepository */
        $productCategoryRepository = $doctrine->getRepository(ProductCategory::class);

        $product = $productRepository->findOneByName('in suscipit');
        $productCategory = $productCategoryRepository->findOneByTitle('et');

        $this->assertEquals('in suscipit', $product->getName());
        $this->assertEquals('By this time she found herself at last it unfolded its arms', $product->getDescription());
        $this->assertEquals('30 g', $product->getWeight());
        $this->assertEquals('et', $product->getCategories()->getValues()[0]->getTitle());

        $this->assertEquals('et', $productCategory->getTitle());
        $this->assertEquals('in suscipit', $productCategory->getProducts()->getValues()[0]->getName());
    }
}
