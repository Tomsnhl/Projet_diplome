<?php

namespace App\Controller\API;

use App\Service\PollService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contrôleur pour gérer les endpoints d'API liés aux sondages.
 */
class PollController extends AbstractController
{
    private $pollService;

    /**
     * Constructeur du PollController.
     *
     * @param PollService $pollService Service pour gérer les sondages.
     */
    public function __construct(PollService $pollService)
    {
        $this->pollService = $pollService;
    }

    /**
     * Endpoint pour créer un nouveau sondage.
     *
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant le nouveau sondage créé.
     */
    public function createPoll(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $poll = $this->pollService->createPoll($data['content']);
        
        return $this->json($poll);
    }

    /**
     * Endpoint pour récupérer un sondage spécifique par son ID.
     *
     * @param int $id ID du sondage à récupérer.
     * @return JsonResponse Réponse contenant le sondage ou une erreur si non trouvé.
     */
    public function getPoll(int $id): JsonResponse
    {
        $poll = $this->pollService->getPoll($id);
        return $this->json($poll);
    }

    // Ajout ici les autres endpoints, par exemple pour la mise à jour, la suppression, etc.
}
