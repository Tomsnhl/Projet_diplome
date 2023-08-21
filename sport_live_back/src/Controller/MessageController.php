<?php

namespace App\Controller;

use App\Entity\Message;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
     * Endpoint pour créer un nouveau message.
     * 
     * @Route("/api/messages", name="create_message", methods={"POST"})
     * 
     * @param Request $request Requête HTTP reçue.
     * @return JsonResponse Réponse contenant le résultat de la création.
     */
    public function createMessage(Request $request): JsonResponse
    {
        // Convertit le contenu JSON de la requête en tableau PHP.
        $data = json_decode($request->getContent(), true);
        
        // Utilise le service pour créer un nouveau message.
        $this->messageService->createMessage($data);
        
        // Renvoie une réponse JSON indiquant que le message a été créé avec succès.
        return $this->json(['message' => 'Message created successfully.']);
    }

    /**
     * Endpoint pour récupérer tous les messages.
     * 
     * @Route("/api/messages", name="get_messages", methods={"GET"})
     * 
     * @return JsonResponse Réponse contenant la liste de tous les messages.
     */
    public function getMessages(): JsonResponse
    {
        // Utilise le service pour récupérer tous les messages.
        $messages = $this->messageService->getAllMessages();
        
        // Convertit la liste des objets Message en tableau pour le format JSON.
        $messagesArray = [];
        foreach ($messages as $message) {
            $messagesArray[] = [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sentDate' => $message->getSentDate()->format('Y-m-d H:i:s'),
                'isApproved' => $message->getIsApproved()
            ];
        }

        // Renvoie la liste des messages sous forme JSON.
        return $this->json(['messages' => $messagesArray]);
    }

    /**
     * Endpoint pour récupérer un message spécifique par son ID.
     * 
     * @Route("/api/messages/{id}", name="get_specific_message", methods={"GET"})
     * 
     * @param int $id ID du message à récupérer.
     * @return JsonResponse Réponse contenant le message ou une erreur si non trouvé.
     */
    public function getSpecificMessage(int $id): JsonResponse
    {
        // Utilise le service pour trouver le message par son ID.
        $message = $this->messageService->getMessageById($id);
        
        // Si le message n'est pas trouvé, renvoie une erreur.
        if (!$message) {
            return $this->json(['error' => 'Message not found'], 404);
        }

        // Sinon, renvoie le message sous forme JSON.
        return $this->json([
            'id' => $message->getId(),
            'content' => $message->getContent(),
            'sentDate' => $message->getSentDate()->format('Y-m-d H:i:s'),
            'isApproved' => $message->getIsApproved()
        ]);
    }

    /**
     * Endpoint pour supprimer un message par son ID.
     * 
     * @Route("/api/messages/{id}", name="delete_message", methods={"DELETE"})
     * 
     * @param int $id ID du message à supprimer.
     * @return JsonResponse Réponse indiquant le résultat de la suppression.
     */
    public function deleteMessage(int $id): JsonResponse
    {
        // Utilise le service pour supprimer le message.
        $this->messageService->deleteMessage($id);
        
        // Renvoie une réponse JSON indiquant que le message a été supprimé avec succès.
        return $this->json(['message' => 'Message deleted successfully.']);
    }
}