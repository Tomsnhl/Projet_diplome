<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour gérer les endpoints d'API liés aux utilisateurs.
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
     * Endpoint pour l'inscription d'un nouvel utilisateur.
     * 
     * @Route("/api/users/register", name="user_register", methods={"POST"})
     * 
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant le résultat de l'inscription.
     */
    public function register(Request $request): JsonResponse
    {
        // Convertit le contenu JSON de la requête en tableau PHP.
        $data = json_decode($request->getContent(), true);

        // Utilise le service pour inscrire un nouvel utilisateur.
        $this->userService->register($data);
        
        // Renvoie une réponse JSON indiquant que l'utilisateur a été inscrit avec succès.
        return $this->json(['message' => 'Inscription réussie.']);
    }

    // Ajoutez d'autres endpoints selon les besoins, par exemple pour la connexion
}

