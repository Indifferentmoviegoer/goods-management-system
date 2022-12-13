<?php

declare(strict_types=1);

namespace App\Service\Product\Messenger;

class ProductImportMessage
{
    protected string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}
