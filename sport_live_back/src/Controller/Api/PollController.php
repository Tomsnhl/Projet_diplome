<?php

namespace App\Controller\API;

use App\Service\PollService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/polls")
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
     * @Route("", name="create_poll", methods={"POST"})
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
     * @Route("/{id}", name="get_specific_poll", methods={"GET"})
     * @param int $id ID du sondage à récupérer.
     * @return JsonResponse Réponse contenant le sondage ou une erreur si non trouvé.
     */
    public function getPoll(int $id): JsonResponse
    {
        $poll = $this->pollService->getPoll($id);
        return $this->json($poll);
    }

    /**
     * Endpoint pour récupérer tous les sondages.
     *
     * @Route("", name="get_all_polls", methods={"GET"})
     * @return JsonResponse Liste de tous les sondages.
     */
    public function getAllPolls(): JsonResponse
    {
        $polls = $this->pollService->getAllPolls();
        return $this->json($polls);
    }

    /**
     * Endpoint pour participer à un sondage.
     *
     * @Route("/{id}/vote", name="vote_poll", methods={"POST"})
     * @param int $id ID du sondage.
     * @param Request $request Requête HTTP contenant les données du vote.
     * @return JsonResponse Résultat de la participation.
     */
    public function votePoll(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        // Supposons que votre service PollService ait une méthode pour gérer le vote.
        // La méthode pourrait prendre l'ID du sondage et les données du vote (par exemple, l'option choisie).
        $this->pollService->voteOnPoll($id, $data);
        
        return $this->json(['message' => 'Vote registered successfully.']);
    }
}
