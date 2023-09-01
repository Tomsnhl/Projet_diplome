<?php

namespace App\Controller\API;

use App\Service\AnswerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/answers")
 */
class AnswerController extends AbstractController
{
    private $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    /**
     * @Route("", name="create_answer", methods={"POST"})
     */
    public function createAnswer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $answer = $this->answerService->createAnswer($data['content'], $data['rank']);
        return $this->json($answer, 200, [], ['groups' => 'answer:read']);
    }

    /**
     * @Route("/{id}", name="get_answer", methods={"GET"})
     */
    public function getAnswer(int $id): JsonResponse
    {
        $answer = $this->answerService->getAnswer($id);
        return $this->json($answer, 200, [], ['groups' => 'answer:read']);
    }

    /**
     * @Route("/{id}", name="update_answer", methods={"PUT"})
     */
    public function updateAnswer(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $answer = $this->answerService->updateAnswer($id, $data['content'], $data['rank']);
        return $this->json($answer, 200, [], ['groups' => 'answer:read']);
    }

    /**
     * @Route("/{id}", name="delete_answer", methods={"DELETE"})
     */
    public function deleteAnswer(int $id): JsonResponse
    {
        $this->answerService->deleteAnswer($id);
        return $this->json(['message' => 'Answer deleted successfully.']);
    }

    /**
     * @Route("", name="get_all_answers", methods={"GET"})
     */
    public function getAllAnswers(): JsonResponse
    {
        $answers = $this->answerService->getAllAnswers();
        return $this->json($answers, 200, [], ['groups' => 'answer:read']);
    }

    /**
    * @Route("/{id}/increment", name="increment_rank", methods={"POST"})
    */
    public function incrementRank(int $id): JsonResponse
    {
        $answer = $this->answerService->incrementRank($id);
        return $this->json($answer, 200, [], ['groups' => 'answer:read']);
    }

}
