<?php

namespace App\Controller;

use App\Service\FruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $fruitService;

    public function __construct(FruitService $fruitService)
    {
        $this->fruitService = $fruitService;
    }

    /**
     * @Route("/api/fruits", name="api_fruits_list", methods={"GET"})
     */
    public function getFruits(Request $request): JsonResponse
    {
        $nameQuery = $request->query->get('name');
        $familyFilter = $request->query->get('family');
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        $fruits = $this->fruitService->getFruits($nameQuery, $familyFilter, $page, $limit);

        return $this->json(
            $fruits,
        );
    }
}
