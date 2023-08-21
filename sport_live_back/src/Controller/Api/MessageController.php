<?php

namespace App\Controller\API;

use App\Entity\Message;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur API pour gérer les endpoints liés aux messages.
 * 
 * @Route("/api/messages")
 */
class MessageController extends AbstractController
{
    private $messageService;

    /**
     * Constructeur du MessageController.
     *
     * @param MessageService $messageService Service pour gérer les messages.
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Crée un nouveau message.
     * 
     * @Route("", name="create_message", methods={"POST"})
     * 
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant le résultat de la création.
     */
    public function createMessage(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->messageService->createMessage($data);
        return $this->json(['message' => 'Message created successfully.']);
    }

    /**
     * Récupère tous les messages.
     * 
     * @Route("", name="get_messages", methods={"GET"})
     * 
     * @return JsonResponse Liste de tous les messages.
     */
    public function getMessages(): JsonResponse
    {
        $messages = $this->messageService->getAllMessages();
        
        $messagesArray = [];
        foreach ($messages as $message) {
            $messagesArray[] = [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sentDate' => $message->getSentDate()->format('Y-m-d H:i:s'),
                'isApproved' => $message->getIsApproved()
            ];
        }

        return $this->json(['messages' => $messagesArray]);
    }

    /**
     * Récupère un message spécifique par son ID.
     * 
     * @Route("/{id}", name="get_specific_message", methods={"GET"})
     * 
     * @param int $id ID du message.
     * @return JsonResponse Message spécifique ou erreur si non trouvé.
     */
    public function getSpecificMessage(int $id): JsonResponse
    {
        $message = $this->messageService->getMessageById($id);
        
        if (!$message) {
            return $this->json(['error' => 'Message not found'], 404);
        }

        return $this->json([
            'id' => $message->getId(),
            'content' => $message->getContent(),
            'sentDate' => $message->getSentDate()->format('Y-m-d H:i:s'),
            'isApproved' => $message->getIsApproved()
        ]);
    }

    /**
     * Supprime un message par son ID.
     * 
     * @Route("/{id}", name="delete_message", methods={"DELETE"})
     * 
     * @param int $id ID du message.
     * @return JsonResponse Résultat de la suppression.
     */
    public function deleteMessage(int $id): JsonResponse
    {
        $this->messageService->deleteMessage($id);
        return $this->json(['message' => 'Message deleted successfully.']);
    }
}
