<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class AuthenticationSuccessListener implements AuthenticationSuccessHandlerInterface
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user = $token->getUser();

        // Vérification que $user est une instance de la classe User
        if (!$user instanceof User) {
            throw new \Exception('L\'utilisateur n\'est pas une instance valide de la classe User');
        }

        $jwt = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $jwt, 'user_id' => $user->getId()]);
    }
}