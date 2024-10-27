<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LocationController.php',
        ]);
    }

    #[Route('/api/locations', name: 'get_locations', methods: ['GET'])]
    public function getLocations(EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $locations = $entityManager->getRepository(Location::class)->findAll();
            return $this->json($locations, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'An error occurred while fetching locations.',
                'details' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
