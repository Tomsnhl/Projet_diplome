<?php

namespace App\Controller\BackOffice;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use App\Repository\PollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur pour la gestion des réponses dans l'administration.
 *
 * @Route("/admin/answers")
 */
class AnswersController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Affiche la liste de toutes les réponses.
     *
     * @Route("/", name="admin_answer_index", methods={"GET"})
     *
     * @param AnswerRepository $answerRepository Le repository pour accéder aux réponses.
     *
     * @return Response La vue affichant la liste des réponses.
     */
    public function index(AnswerRepository $answerRepository): Response
    {
        $answers = $answerRepository->findAllWithPolls();

        return $this->render('back/answer/list.html.twig', [
            'answers' => $answers,
        ]);
    }

    /**
     * Crée une nouvelle réponse.
     *
     * @Route("/new/{poll_id}", name="admin_answer_new", methods={"GET","POST"})
     */
    public function new(int $poll_id, Request $request, EntityManagerInterface $entityManager, PollRepository $pollRepository): Response
    {
        $poll = $pollRepository->find($poll_id);
        if (!$poll) {
            throw $this->createNotFoundException('Sondage non trouvé');
        }

        $answer = new Answer();
        $answer->setPoll($poll);

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $totalAnswers = count($this->doctrine->getRepository(Answer::class)->findAll());
            $answer->setRanking($totalAnswers + 1);

            $entityManager->persist($answer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_polls_show', ['id' => $poll_id]);
        }

        return $this->render('back/answer/new.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifie une réponse existante.
     *
     * @Route("/{id}/edit/{poll_id}", name="admin_answer_edit", methods={"GET","POST"})
     */
    public function edit(int $id, int $poll_id, Request $request, AnswerRepository $answerRepository, EntityManagerInterface $entityManager): Response
    {
        $answer = $answerRepository->find($id);

        if (!$answer) {
            throw $this->createNotFoundException('Réponse non trouvée');
        }

        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_polls_show', ['id' => $poll_id]);
        }

        return $this->render('back/answer/edit.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
 * Supprime une réponse existante.
 *
 * @Route("/{id}/delete", name="admin_answer_delete", methods={"POST"})
 *
 * @param int $poll_id L'ID du sondage associé à la réponse.
 * @param int $id L'ID de la réponse à supprimer.
 * @param Request $request L'objet request pour gérer les requêtes HTTP.
 * @param AnswerRepository $answerRepository Le repository pour accéder aux réponses.
 * @param EntityManagerInterface $entityManager L'entity manager pour gérer les entités.
 *
 * @return Response La redirection vers la liste des réponses.
 */
public function delete(int $id, Request $request, AnswerRepository $answerRepository, EntityManagerInterface $entityManager): Response
{
    // Récupération de la réponse à supprimer.
    $answer = $answerRepository->find($id);

    // Vérification que la réponse existe.
    if (!$answer) {
        throw $this->createNotFoundException('Réponse non trouvée');
    }

    // Récupération de l'ID du sondage associé à la réponse.
    $pollId = $answer->getPoll()->getId();

    // Vérification du token CSRF.
    if ($this->isCsrfTokenValid('delete' . $answer->getId(), $request->request->get('_token'))) {
        // Suppression de la réponse de la base de données.
        $entityManager->remove($answer);
        $entityManager->flush();
    }

    // Redirection vers la page "show" du sondage.
    return $this->redirectToRoute('admin_polls_show', ['id' => $pollId]);
}


    /**
     * Affiche les détails d'une réponse.
     *
     * @Route("/{id}", name="admin_answer_show", methods={"GET"})
     *
     * @param Answer $answer L'objet réponse à afficher.
     *
     * @return Response La vue affichant les détails de la réponse.
     */
    public function show(Answer $answer): Response
    {
        return $this->render('back/answer/show.html.twig', [
            'answer' => $answer,
        ]);
    }
}
