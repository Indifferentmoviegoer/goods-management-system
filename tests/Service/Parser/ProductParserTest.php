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

        $products = $productRepository->findAll();
        $productCategories = $productCategoryRepository->findAll();

        $this->assertEquals('in suscipit', $products[0]->getName());
        $this->assertEquals('By this time she found herself at last it unfolded its arms', $products[0]->getDescription());
        $this->assertEquals('30 g', $products[0]->getWeight());
        $this->assertEquals('et', $products[0]->getCategories()->getValues()[0]->getTitle());
        $this->assertEquals('in suscipit2', $products[1]->getName());
        $this->assertEquals('By2 this time she found herself at last it unfolded its arms', $products[1]->getDescription());
        $this->assertEquals('302 g', $products[1]->getWeight());
        $this->assertEquals('et2', $products[1]->getCategories()->getValues()[0]->getTitle());

        $this->assertEquals('et', $productCategories[0]->getTitle());
        $this->assertEquals('in suscipit', $productCategories[0]->getProducts()->getValues()[0]->getName());
        $this->assertEquals('et2', $productCategories[1]->getTitle());
        $this->assertEquals('in suscipit2', $productCategories[1]->getProducts()->getValues()[0]->getName());
    }
}
