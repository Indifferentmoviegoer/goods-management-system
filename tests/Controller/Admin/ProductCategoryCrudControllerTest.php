<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ProductCategoryCrudController;
use App\Entity\ProductCategory;
use App\Tests\Common\WebTestCase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ProductCategoryCrudControllerTest extends WebTestCase
{
    public function testGetEntityFqcn(): void
    {
        $productCategoryCrudController = $this->getContainer()->get(ProductCategoryCrudController::class);

        $this->assertEquals(ProductCategory::class, $productCategoryCrudController::getEntityFqcn());
    }

    public function testConfigureCrud(): void
    {
        $productCategoryCrudController = $this->getContainer()->get(ProductCategoryCrudController::class);

        $this->assertInstanceOf(Crud::class, $productCategoryCrudController->configureCrud(Crud::new()));
    }

    public function testConfigureFields(): void
    {
        $productCategoryCrudController = $this->getContainer()->get(ProductCategoryCrudController::class);

        $this->assertCount(2, iterator_to_array($productCategoryCrudController->configureFields(Crud::PAGE_INDEX)));
        $this->assertCount(2, iterator_to_array($productCategoryCrudController->configureFields(Crud::PAGE_EDIT)));
    }

    public function testConfigureActions(): void
    {
        $productCategoryCrudController = $this->getContainer()->get(ProductCategoryCrudController::class);

        $this->assertInstanceOf(Actions::class, $productCategoryCrudController->configureActions(Actions::new()));
    }
}
