<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Service\Product\Messenger\ProductImportMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductService
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function importFromXml(string $filePath): Envelope
    {
        return $this->messageBus->dispatch((new ProductImportMessage($filePath)));
    }
}