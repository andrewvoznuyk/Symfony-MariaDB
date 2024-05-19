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
        $data = $this->productRepository->getGroupedProductData();

        return new JsonResponse($this->formatProductData($data), Response::HTTP_OK);
    }

    private function formatProductData(array $data): array
    {
        $formattedResult = [];

        foreach ($data as $item) {
            $code = $item['Code'];
            $type = $item['Type'];
            $totalItems = $item['TotalItems'];
            $totalPrice = $item['TotalPrice'];

            $formattedResult[$code]['code'] = $code;
            $formattedResult[$code]['totalCodePrice'] = ($formattedResult[$code]['totalCodePrice'] ?? 0) + $totalPrice;
            $formattedResult[$code]['totalCodeItems'] = ($formattedResult[$code]['totalCodeItems'] ?? 0) + $totalItems;

            $formattedResult[$code]['types'][$type]['TotalItems'] = ($formattedResult[$code]['types'][$type]['TotalItems'] ?? 0) + $totalItems;
            $formattedResult[$code]['types'][$type]['TotalPrice'] = ($formattedResult[$code]['types'][$type]['TotalPrice'] ?? 0) + $totalPrice;
        }

        return array_values($formattedResult);
    }
}
