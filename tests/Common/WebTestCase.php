<?php

declare(strict_types=1);

namespace App\Tests\Common;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Product;
use App\Entity\ProductCategory;
use App\Helper\FileHelper;
use App\Repository\ProductCategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WebTestCase extends ApiTestCase
{
    protected const METHOD_POST = 'POST';
    protected const METHOD_GET = 'GET';
    protected const METHOD_PATCH = 'PATCH';
    protected const METHOD_DELETE = 'DELETE';

    private const FILE_RELATIVE_PATH = 'tests/Common/import.xml';
    private const COPY_FILE_RELATIVE_PATH = 'public/uploads/import.xml';

    protected function getXmlFilePath(): string
    {
        return sprintf('%s/%s', dirname(__DIR__, 2), self::FILE_RELATIVE_PATH);
    }

    protected function getXmlCopyFilePath(): string
    {
        return sprintf('%s/%s', dirname(__DIR__, 2), self::COPY_FILE_RELATIVE_PATH);
    }

    protected function getEntityManager(): Registry
    {
        return $this->getContainer()->get(ManagerRegistry::class);
    }

    protected function getProductRepository(): ProductRepository
    {
        return $this->getEntityManager()->getRepository(Product::class);
    }

    protected function getProductCategoryRepository(): ProductCategoryRepository
    {
        return $this->getEntityManager()->getRepository(ProductCategory::class);
    }

    protected function getFileHelper(): FileHelper
    {
        return $this->getContainer()->get(FileHelper::class);
    }

    protected function jsonRequest(
        Client $client,
        string $method,
        string $uri,
        array $data = []
    ): ResponseInterface {
        $queryString = '';
        $options = [];
        $headers = [
            'Accept' => 'application/json',
        ];

        switch ($method) {
            case 'GET':
                foreach ($data as $key => $value) {
                    if (!empty($queryString)) {
                        $queryString .= '&';
                    }

                    $queryString .= $key . '=' . $value;
                }
                break;
            case 'PUT':
            case 'POST':
                $headers['Content-Type'] = 'application/json';
                $options['json'] = $data;
                break;
            case 'PATCH':
                $headers['Content-Type'] = 'application/merge-patch+json';
                $options['json'] = $data;
                break;
        }

        $options = array_merge($options, [
            'headers' => $headers,
        ]);

        return $client->request($method, $uri . '?' . $queryString, $options);
    }
}