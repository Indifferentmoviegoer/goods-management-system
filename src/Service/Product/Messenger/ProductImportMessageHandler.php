<?php

declare(strict_types=1);

namespace App\Service\Product\Messenger;

use App\Service\Parser\ProductParser;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ProductImportMessageHandler
{
    private ProductParser $productParser;
    private LoggerInterface $logger;

    public function __construct(ProductParser $productParser, LoggerInterface $logger)
    {
        $this->productParser = $productParser;
        $this->logger = $logger;
    }

    public function __invoke(ProductImportMessage $message): void
    {
        try {
            $this->productParser->parserXml($message->getFileName());

        } catch (Exception $exception) {
            $this->logger->error(sprintf('Product ERROR [%s]', $exception->getMessage()));
        }
    }
}
