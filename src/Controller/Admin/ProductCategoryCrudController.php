<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\ProductCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductCategory::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Категория')
            ->setEntityLabelInPlural('Категории')
            ->setSearchFields(['id', 'title']);
    }

    public function configureFields(string $pageName): iterable
    {
        if (Crud::PAGE_INDEX === $pageName) {
            yield IntegerField::new('id', 'ID');
        }

        yield TextField::new('title', 'Наименование категории');

        if (Crud::PAGE_INDEX !== $pageName) {
            yield AssociationField::new('products', 'Товары')->autocomplete();
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $coverage = Action::new('coverage', 'Покрытие тестами', 'fa fa-pie-chart')
            ->setCssClass('btn btn-secondary action-foo')
            ->linkToUrl('/coverage/')
            ->createAsGlobalAction();

        $actions->add(Crud::PAGE_INDEX, $coverage);

        return parent::configureActions($actions);
    }
}
