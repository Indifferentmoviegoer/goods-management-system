<?php

declare(strict_types=1);

namespace App\Dto;

class ProductsDto
{
    /**
     * @var ProductDto[]
     */
    private ?array $product = null;

    /**
     * @return ProductDto[]|null
     */
    public function getProduct(): ?array
    {
        return $this->product;
    }

    /**
     * @param ProductDto[] $product
     */
    public function setProduct(array $product): void
    {
        $this->product = $product;
    }

    public function addProduct(ProductDto $product): void
    {
        $this->product[] = $product;
    }
}