<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\ProductCrudController;
use App\Entity\Product;
use App\Tests\Common\WebTestCase;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ProductCrudControllerTest extends WebTestCase
{

    public function testGetEntityFqcn(): void
    {
        $productCrudController = $this->getContainer()->get(ProductCrudController::class);

        $this->assertEquals(Product::class, $productCrudController::getEntityFqcn());
    }

    public function testConfigureCrud(): void
    {
        $productCrudController = $this->getContainer()->get(ProductCrudController::class);

        $this->assertInstanceOf(Crud::class, $productCrudController->configureCrud(Crud::new()));
    }

    public function testConfigureFields(): void
    {
        $productCrudController = $this->getContainer()->get(ProductCrudController::class);

        $this->assertCount(3, iterator_to_array($productCrudController->configureFields(Crud::PAGE_INDEX)));
        $this->assertCount(3, iterator_to_array($productCrudController->configureFields(Crud::PAGE_EDIT)));
    }

    public function testConfigureActions(): void
    {
        $productCrudController = $this->getContainer()->get(ProductCrudController::class);

        $this->assertInstanceOf(Actions::class, $productCrudController->configureActions(Actions::new()));
    }
}
