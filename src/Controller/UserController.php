<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/api/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $entityManager): JsonResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return new JsonResponse($users);
    }

    #[Route('/api/users/{id}', name: 'edit_user', methods: ['PUT'])]
    public function editUser(int $id, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $user->setFirstName(trim($data['firstName'])?? '');
        $user->setLastName(trim($data['lastName']) ?? '');
        $user->setEmail(trim($data['email']) ?? '');

        // Validate user
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User updated successfully'], 200);
    }
}
