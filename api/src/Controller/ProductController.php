<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{
    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(private ProductRepository $productRepository)
    {}

    /**
     * @return JsonResponse
     */
    #[Route(path: "/productStats", name: "productStats", methods: ["GET"])]
    public function productStats() : JsonResponse
    {
        return new JsonResponse($this->productRepository->getGroupedProductData(), Response::HTTP_OK);
    }
}
