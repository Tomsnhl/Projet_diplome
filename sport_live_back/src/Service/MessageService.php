<?php

namespace App\Service;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Service pour gérer les opérations liées aux messages.
 */
class MessageService
{
    // Cette propriété stocke une référence vers le service ManagerRegistry de Doctrine
    private $managerRegistry;

    /**
     * Constructeur du service.
     *
     * @param ManagerRegistry $managerRegistry Le registre des gestionnaires de Doctrine (pour interagir avec la base de données).
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Crée un nouveau message en base de données.
     *
     * @param array $data Les données du message à créer (e.g. content).
     * @return Message L'objet Message qui a été créé et sauvegardé.
     */
    public function createMessage(array $data): Message
{
    // Vérification de l'existence des clés nécessaires dans le tableau de données
    if (!isset($data['content']) || !isset($data['user_id'])) {
        throw new \Exception('Missing necessary data keys: content or user_id');
    }

    // Création d'une nouvelle instance de Message
    $message = new Message();
    $message->setContent($data['content']);
    $message->setSentDate(new \DateTime());  // La date actuelle est utilisée comme date d'envoi
    $message->setIsApproved(false);  // Attribuer une valeur par défaut à isApproved
    $message->setIsDeleted(false);  // Attribuer une valeur par défaut à isDeleted

    // Obtention de l'entity manager
    $entityManager = $this->managerRegistry->getManager();

    // Recherche de l'utilisateur associé et liaison avec le message
    $user = $entityManager->getRepository(User::class)->find($data['user_id']);
    if (!$user) {
        throw new \Exception('User not found');
    }
    $message->setUser($user);

    // Sauvegarde du message dans la base de données
    $entityManager->persist($message);
    $entityManager->flush();

    return $message;
}

    /**
     * Récupère tous les messages de la base de données du plus ancien au plus récent.
     *
     * @return array Une liste d'objets Message.
     */
    public function getAllMessages(): array
    {
        // Utilisation de Doctrine pour récupérer tous les messages et findBy pour les triers
        return $this->managerRegistry->getRepository(Message::class)->findBy([],['sentDate'=>'DESC']);
    }

    
    /**
     * Récupère un message spécifique par son ID.
     *
     * @param int $id L'ID du message à récupérer.
     * @return Message|null L'objet Message ou null si non trouvé.
     */
    public function getMessageById(int $id): ?Message
    {
        // Utilisation de Doctrine pour récupérer le message par son ID
        return $this->managerRegistry->getRepository(Message::class)->find($id);
    }

    /**
     * Supprime un message de la base de données en utilisant son ID.
     *
     * @param int $id L'ID du message à supprimer.
     */
    public function deleteMessage(int $id): void
    {
        $entityManager = $this->managerRegistry->getManager();
        // Recherche du message par son ID
        $message = $entityManager->getRepository(Message::class)->find($id);
    
        // Si le message n'est pas trouvé, on retourne sans rien faire
        if (!$message) {
            return;
        }
    
        // Suppression du message de la base de données
        $entityManager->remove($message);
        $entityManager->flush();
    }
}

