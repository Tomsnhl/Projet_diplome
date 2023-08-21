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

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function createPoll(string $content): Poll
    {
        $poll = new Poll();
        $poll->setContent($content);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($poll);
        $entityManager->flush();

        return $poll;
    }

    public function getPoll(int $id): ?Poll
    {
        return $this->managerRegistry->getRepository(Poll::class)->find($id);
    }

    public function updatePoll(Poll $poll, string $content): Poll
    {
        $poll->setContent($content);
        
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($poll);
        $entityManager->flush();

        return $poll;
    }

    public function deletePoll(Poll $poll): void
    {
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->remove($poll);
        $entityManager->flush();
    }
}
