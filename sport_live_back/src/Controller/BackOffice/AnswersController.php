<?php

namespace App\Controller\BackOffice;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
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
        // Récupération de toutes les réponses de la base de données.
        $answers = $answerRepository->findAll();

        // Rendu du template avec la liste des réponses.
        return $this->render('back/answer/index.html.twig', [
            'answers' => $answers,
        ]);
    }

    /**
     * Crée une nouvelle réponse.
     *
     * @Route("/new", name="admin_answer_new", methods={"GET","POST"})
     *
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param EntityManagerInterface $entityManager L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour créer une nouvelle réponse ou la redirection vers la liste des réponses.
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de la classe Answer.
        $answer = new Answer();

        // Création du formulaire pour une nouvelle réponse.
        $form = $this->createForm(AnswerType::class, $answer);

        // Gestion de la requête du formulaire.
        $form->handleRequest($request);

        // Vérification que le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Obtenez le nombre total de réponses existantes
            $totalAnswers = count($this->doctrine->getRepository(Answer::class)->findAll());

            // Incrémentez le classement de la nouvelle réponse
            $answer->setRanking($totalAnswers + 1);

            // Persistance de la nouvelle réponse dans la base de données.
            $entityManager->persist($answer);
            $entityManager->flush();

            // Redirection vers la liste des réponses.
            return $this->redirectToRoute('admin_answer_index');
        }

        // Rendu du template pour créer une nouvelle réponse.
        return $this->render('back/answer/new.html.twig', [
            'answer' => $answer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Modifie une réponse existante.
     *
     * @Route("/{id}/edit", name="admin_answer_edit", methods={"GET","POST"})
     *
     * @param int $id L'ID de la réponse à modifier.
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param AnswerRepository $answerRepository Le repository pour accéder aux réponses.
     * @param EntityManagerInterface $entityManager L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour modifier une réponse ou la redirection vers la liste des réponses.
     */
    public function edit(int $id, Request $request, AnswerRepository $answerRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupération de la réponse à modifier.
        $answer = $answerRepository->find($id);

        // Vérification que la réponse existe.
        if (!$answer) {
            throw $this->createNotFoundException('Réponse non trouvée');
        }

        // Création du formulaire pour modifier la réponse.
        $form = $this->createForm(AnswerType::class, $answer);

        // Gestion de la requête du formulaire.
        $form->handleRequest($request);

        // Vérification que le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Mise à jour de la réponse dans la base de données.
            $entityManager->flush();

            // Redirection vers la liste des réponses.
            return $this->redirectToRoute('admin_answer_index');
        }

        // Rendu du template pour modifier une réponse.
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

    // Vérification du token CSRF.
    if ($this->isCsrfTokenValid('delete' . $answer->getId(), $request->request->get('_token'))) {
        // Suppression de la réponse de la base de données.
        $entityManager->remove($answer);
        $entityManager->flush();
    }

    // Redirection vers la liste des réponses.
    return $this->redirectToRoute('admin_answer_index');
}
}

