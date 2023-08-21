<?php

namespace App\Controller\API;

use App\Service\AnswerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Contrôleur pour gérer les endpoints d'API liés aux réponses.
 */
class AnswerController extends AbstractController
{
    private $answerService;

    /**
     * Constructeur du AnswerController.
     *
     * @param AnswerService $answerService Service pour gérer les réponses.
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * Endpoint pour créer une nouvelle réponse.
     *
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant la nouvelle réponse créée.
     */
    public function createAnswer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $answer = $this->answerService->createAnswer($data['content'], $data['rank']);
        
        return $this->json($answer);
    }

    /**
     * Endpoint pour récupérer une réponse spécifique par son ID.
     *
     * @param int $id ID de la réponse à récupérer.
     * @return JsonResponse Réponse contenant la réponse ou une erreur si non trouvée.
     */
    public function getAnswer(int $id): JsonResponse
    {
        $answer = $this->answerService->getAnswer($id);
        return $this->json($answer);
    }

    // Ajout ici les autres endpoints, par exemple pour la mise à jour, la suppression, etc.
}

