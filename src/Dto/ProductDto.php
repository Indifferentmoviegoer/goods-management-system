<?php

declare(strict_types=1);

namespace App\Dto;

class ProductDto
{
    private ?string $name = null;
    private ?string $description = null;
    private ?string $weight = null;
    private ?string $category = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): ProductDto
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ProductDto
    {
        $this->description = $description;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): ProductDto
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): ProductDto
    {
        $this->category = $category;

        return $this;
    }
}