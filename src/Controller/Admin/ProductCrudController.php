<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Товар')
            ->setEntityLabelInPlural('Товары')
            ->setSearchFields(['name', 'description']);
    }

    public function configureActions(Actions $actions): Actions
    {
        $productImport = Action::new('productImport', 'Импорт товаров', 'fa fa-file-invoice')
            ->setCssClass('btn btn-success action-foo')
            ->linkToRoute('productImport')
            ->createAsGlobalAction();

        $actions->add(Crud::PAGE_INDEX, $productImport);

        return parent::configureActions($actions);
    }

}
