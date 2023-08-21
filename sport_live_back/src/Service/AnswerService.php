<?php

namespace App\Service;

use App\Entity\Answer;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Service pour gérer les opérations liées aux réponses.
 */
class AnswerService
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createAnswer(string $content, int $rank): Answer
    {
        $answer = new Answer();
        $answer->setContent($content);
        $answer->setRank($rank);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($answer);
        $entityManager->flush();

        return $answer;
    }

    public function getAnswer(int $id): ?Answer
    {
        return $this->managerRegistry->getRepository(Answer::class)->find($id);
    }

    public function updateAnswer(Answer $answer, string $content, int $rank): Answer
    {
        $answer->setContent($content);
        $answer->setRank($rank);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($answer);
        $entityManager->flush();

        return $answer;
    }

    public function deleteAnswer(Answer $answer): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($answer);
        $entityManager->flush();
    }
}
