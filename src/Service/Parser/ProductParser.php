<?php

declare(strict_types=1);

namespace App\Service\Parser;

use App\Dto\ProductsDto;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Helper\FileHelper;
use App\Helper\ImportHelper;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductParser
{
    private FileHelper $fileHelper;
    private ManagerRegistry $doctrine;

    public function __construct(FileHelper $fileHelper, ManagerRegistry $doctrine)
    {
        $this->fileHelper = $fileHelper;
        $this->doctrine = $doctrine;
    }

    /**
     * @throws Exception
     */
    public function parserXml(string $fileName): void
    {
        ImportHelper::initImportOptions();

        $xmlContent = $this->getXmlContent($fileName);
        $productsDto = $this->deserializeXmlToObject($xmlContent);

        foreach ($productsDto->getProduct() as $item) {
            $productCategory = $this->createOrUpdateProductCategory((object)$item);
            $product = $this->createOrUpdateProduct((object)$item, $productCategory);
            $this->createOrUpdateProductCategory((object)$item, $product);
        }
    }

    private function getXmlContent(string $fileName): string|false
    {
        $url = sprintf('%s/%s', $this->fileHelper->getUploadsDirectory(), $fileName);

        return file_get_contents($url);
    }

    private function deserializeXmlToObject(bool|string $xmlContent): ProductsDto
    {
        $encoders = [new XmlEncoder()];
        $normalizers = [
            new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            ),
        ];
        $serializer = new Serializer($normalizers, $encoders);

        /** @var ProductsDto $productsDto */
        $productsDto = $serializer->deserialize($xmlContent, ProductsDto::class, 'xml');

        return $productsDto;
    }

    /**
     * @throws NonUniqueResultException
     */
    private function createOrUpdateProductCategory($item, ?Product $product = null): ?ProductCategory
    {
        /** @var ProductCategoryRepository $productCategoryRepository */
        $productCategoryRepository = $this->doctrine->getRepository(ProductCategory::class);

        $productCategory = $productCategoryRepository->findOneByTitle($item->category) ?: new ProductCategory();
        $productCategory->setTitle($item->category);

        if ($product) {
            $productCategory->addProduct($product);
        }

        $productCategoryRepository->save($productCategory, true);

        return $productCategory;
    }

    /**
     * @throws NonUniqueResultException
     */
    private function createOrUpdateProduct($item, ?ProductCategory $productCategory = null): ?Product
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->doctrine->getRepository(Product::class);

        $product = $productRepository->findOneByName($item->name) ?: new Product();
        $product
            ->setName($item->name)
            ->setDescription($item->description)
            ->setWeight($item->weight);

        if ($productCategory) {
            $product->addCategory($productCategory);
        }

        $productRepository->save($product, true);

        return $product;
    }
}