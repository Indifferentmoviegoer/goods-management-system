<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\FileUploadType;
use App\Helper\FileHelper;
use App\Service\Product\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/productImport', name: 'productImport')]
    public function index(Request $request, FileHelper $fileHelper, ProductService $productService): Response
    {
        $form = $this->createForm(FileUploadType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['upload_file']->getData();

            if ($file && $filePath = $fileHelper->upload($file)) {
                $productService->importFromXml($filePath);

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('product/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
