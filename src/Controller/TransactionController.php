<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'app_transaction')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TransactionController.php',
        ]);
    }

    #[Route('/api/transactions', name: 'get_transactions', methods: ['GET'])]
    public function getTransactions(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $userId = $request->query->get('userId');
        $locationId = $request->query->get('locationId');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $page = max((int)$request->query->get('page', 1), 1);
        $limit = max((int)$request->query->get('limit', 10), 1);

        try {
            $startDate = $startDate ? new \DateTime($startDate) : null;
            $endDate = $endDate ? new \DateTime($endDate) : null;

            $transactions = $entityManager->getRepository(Transaction::class)->findByFilters(
                $userId ? (int)$userId : null,
                $locationId ? (int)$locationId : null,
                $startDate,
                $endDate,
                $page,
                $limit
            );

            $totalCount = $entityManager->getRepository(Transaction::class)->countByFilters(
                $userId ? (int)$userId : null,
                $locationId ? (int)$locationId : null,
                $startDate,
                $endDate
            );

            return $this->json([
                'transactions' => $transactions,
                'totalCount' => $totalCount,
                'currentPage' => $page,
                'limit' => $limit,
                'totalPages' => ceil($totalCount / $limit),
            ]);
        } catch (\Exception $e) {
            return $this->json(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
