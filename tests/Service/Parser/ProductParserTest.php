<?php

declare(strict_types=1);

namespace App\Tests\Service\Parser;

use App\Service\Parser\ProductParser;
use App\Tests\Common\WebTestCase;

class ProductParserTest extends WebTestCase
{
    public function testParserXml()
    {
        $productParser = $this->getContainer()->get(ProductParser::class);
        $productParser->parserXml($this->getXmlFilePath());

        $products = $this->getProductRepository()->findAll();
        $productCategories = $this->getProductCategoryRepository()->findAll();

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
