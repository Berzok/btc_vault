<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/auth', name: 'auth_')]
class LoginController extends AbstractController {

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response {
        // Cette route est gérée automatiquement par LexikJWTAuthenticationBundle
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            return $this->json(['error' => 'Invalid credentials'], 401);
        }
        
        return new Response('ok');
    }
}
