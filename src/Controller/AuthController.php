<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/auth')]
class AuthController extends AbstractController {

    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(UserInterface $user): JsonResponse {
        return new JsonResponse([
            'message' => 'Successfully logged in!'
        ]);
    }
}
