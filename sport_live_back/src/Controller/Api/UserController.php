<?php

namespace App\Controller\API;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur API pour gérer les endpoints liés aux utilisateurs.
 * 
 * @Route("/api/users")
 */
class UserController extends AbstractController
{
    private $userService;

    /**
     * Constructeur du UserController.
     *
     * @param UserService $userService Service pour gérer les utilisateurs.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Inscription d'un nouvel utilisateur.
     * 
     * @Route("/register", name="user_register", methods={"POST"})
     * 
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant le résultat de l'inscription.
     */
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->userService->register($data);
        return $this->json(['message' => 'Inscription réussie.']);
    }

    // Ajout d'autres endpoints selon les besoins, par exemple pour la connexion
}
