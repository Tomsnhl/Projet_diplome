<?php 

namespace App\Service;

use App\Entity\Poll;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Service pour gérer les opérations liées aux sondages.
 */
class PollService
{
    private $managerRegistry;

    /**
     * Constructeur du service PollService.
     *
     * @param ManagerRegistry $managerRegistry Le registre des gestionnaires de Doctrine (pour interagir avec la base de données).
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Crée un nouveau sondage en base de données.
     *
     * @param string $content Le contenu du sondage.
     * @return Poll L'objet Poll qui a été créé et sauvegardé.
     */
    public function createPoll(string $content): Poll
    {
        $poll = new Poll();
        $poll->setContent($content);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($poll);
        $entityManager->flush();

        return $poll;
    }

    /**
     * Récupère un sondage spécifique par son ID.
     *
     * @param int $id L'ID du sondage à récupérer.
     * @return Poll|null L'objet Poll ou null si non trouvé.
     */
    public function getPoll(int $id): ?Poll
    {
        return $this->managerRegistry->getRepository(Poll::class)->find($id);
    }

    /**
     * Récupère tous les sondages de la base de données.
     *
     * @return array Une liste d'objets Poll.
     */
    public function getAllPolls(): array
    {
        return $this->managerRegistry->getRepository(Poll::class)->findAll();
    }

    /**
     * Met à jour un sondage existant en base de données.
     *
     * @param Poll $poll L'objet Poll à mettre à jour.
     * @param string $content Le nouveau contenu du sondage.
     * @return Poll L'objet Poll mis à jour.
     */
    public function updatePoll(Poll $poll, string $content): Poll
    {
        $poll->setContent($content);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($poll);
        $entityManager->flush();

        return $poll;
    }

    /**
     * Supprime un sondage de la base de données.
     *
     * @param Poll $poll L'objet Poll à supprimer.
     */
    public function deletePoll(Poll $poll): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($poll);
        $entityManager->flush();
    }

    /**
     * Enregistre un vote pour un sondage spécifique.
     * 
     * @param int $id L'ID du sondage.
     * @param array $data Les données du vote (par exemple, l'option choisie).
     */
    public function voteOnPoll(int $id, array $data): void
    {
        // Vous devriez mettre en œuvre la logique pour enregistrer un vote ici.
        // Par exemple, incrémenter le compte d'une option spécifique.
        // N'oubliez pas de sauvegarder les modifications avec $entityManager->flush().
    }
}
