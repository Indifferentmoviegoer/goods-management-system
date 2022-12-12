<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            ->setSearchFields(['id','name', 'description', 'weight']);
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            yield IntegerField::new('id', 'ID');
        }

        yield TextField::new('name', 'Наименование товара');
        yield TextField::new('weight', 'Вес товара');

        if (Crud::PAGE_INDEX !== $pageName) {
            yield AssociationField::new('categories', 'Категории')->autocomplete();
        }
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
