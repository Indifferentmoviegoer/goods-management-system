<?php

declare(strict_types=1);

namespace App\Helper;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileHelper
{
    private SluggerInterface $slugger;
    private LoggerInterface $logger;
    private string $projectDir;

    public function __construct(SluggerInterface $slugger, LoggerInterface $logger, string $projectDir)
    {
        $this->slugger = $slugger;
        $this->logger = $logger;
        $this->projectDir = $projectDir;
    }

    public function upload(UploadedFile $file): ?string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = sprintf('%s-%s.%s', $safeFilename, uniqid(), $file->guessExtension());

        try {
            $file->move($this->getUploadsDirectory(), $fileName);

        } catch (FileException $e) {
            $this->logger->error(sprintf('FILE ERROR [%s]', $e->getMessage()));

            return null;
        }

        return $fileName;
    }

    public function getPublicDir(): string
    {
        return sprintf('%s/public', $this->projectDir);
    }

    public function getUploadsDirectory(): string
    {
        return sprintf('%s/uploads', $this->getPublicDir());
    }
}
