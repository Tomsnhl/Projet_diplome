<?php

namespace App\Service;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Service pour gérer les opérations sur les réponses.
 * Ce service interagit directement avec la base de données.
 */
class AnswerService
{
    private $managerRegistry;

    /**
     * Le constructeur injecte le ManagerRegistry de Doctrine.
     *
     * @param ManagerRegistry $managerRegistry Utilisé pour interagir avec la base de données.
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * Crée une nouvelle réponse.
     *
     * @param string $content Le contenu de la réponse.
     * @param int $rank Le rang de la réponse.
     * @return Answer La réponse créée.
     */
    public function createAnswer(string $content, int $rank): Answer
    {
        $answer = new Answer();
        $answer->setContent($content);
        $answer->setRanking($rank);

        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($answer);
        $entityManager->flush();

        return $answer;
    }

    /**
     * Récupère une réponse par son ID.
     *
     * @param int $id L'ID de la réponse.
     * @return Answer|null La réponse récupérée ou null si elle n'est pas trouvée.
     */
    public function getAnswer(int $id): ?Answer
    {
        return $this->managerRegistry->getRepository(Answer::class)->find($id);
    }

    /**
     * Met à jour une réponse existante.
     *
     * @param int $id L'ID de la réponse.
     * @param string $content Le nouveau contenu.
     * @param int $rank Le nouveau rang.
     * @return Answer La réponse mise à jour.
     */
    public function updateAnswer(int $id, string $content, int $rank): Answer
    {
        $answer = $this->getAnswer($id);

        if (!$answer) {
            throw new \Exception("Answer not found");
        }

        $answer->setContent($content);
        $answer->setRankink($rank);

        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($answer);
        $entityManager->flush();

        return $answer;
    }

    /**
     * Supprime une réponse.
     *
     * @param int $id L'ID de la réponse.
     */
    public function deleteAnswer(int $id): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $answer = $entityManager->getRepository(Answer::class)->find($id);

        if (!$answer) {
            throw new \Exception("Answer not found");
        }

        $entityManager->remove($answer);
        $entityManager->flush();
    }


    /**
    * Récupère toutes les réponses de la base de données.
    *
    * @return array Une liste de toutes les réponses.
    */
    public function getAllAnswers(): array
    {

    return $this->managerRegistry->getRepository(Answer::class)->findAll();
    
    }

    

    public function incrementRank(int $id): Answer
{
    $answer = $this->getAnswer($id);

    if (!$answer) {
        throw new \Exception("Answer not found");
    }

    $currentRanking = $answer->getRanking();
    $answer->setRanking($currentRanking + 1);

    $entityManager = $this->managerRegistry->getManager();
    $entityManager->persist($answer);
    $entityManager->flush();

    return $answer;
}



};