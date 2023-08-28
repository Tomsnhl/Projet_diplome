<?php

namespace App\Controller\BackOffice;

use App\Entity\Poll;
use App\Form\PollType;  
use App\Repository\PollRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/polls")
 */
class PollController extends AbstractController {

    /**
     * Affiche la liste de tous les sondages.
     *
     * @Route("/", name="admin_polls_index")
     *
     * @param PollRepository $pollRepository Le repository pour accéder aux sondages.
     *
     * @return Response La vue affichant la liste des sondages.
     */
    public function index(PollRepository $pollRepository): Response {
        $polls = $pollRepository->findAll();

        return $this->render('back/poll/list.html.twig', [
            'polls' => $polls
        ]);
    }

    /**
     * Crée un nouveau sondage.
     *
     * @Route("/new", name="admin_polls_new")
     *
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param EntityManagerInterface $em L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour la création de sondage ou la redirection vers la liste des sondages.
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
        $poll = new Poll();
        $form = $this->createForm(PollType::class, $poll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($poll);
            $em->flush();

            return $this->redirectToRoute('admin_polls_index');
        }

        return $this->render('back/poll/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Affiche les détails d'un sondage spécifique.
     *
     * @Route("/{id}", name="admin_polls_show")
     *
     * @param Poll $poll Le sondage à afficher.
     *
     * @return Response La vue affichant les détails du sondage.
     */
    public function show(Poll $poll): Response {
        return $this->render('back/poll/show.html.twig', [
            'poll' => $poll
        ]);
    }

    /**
     * Modifie un sondage spécifique.
     *
     * @Route("/{id}/edit", name="admin_polls_edit")
     *
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param Poll $poll Le sondage à modifier.
     * @param EntityManagerInterface $em L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour l'édition de sondage ou la redirection vers la liste des sondages.
     */
    public function edit(Request $request, Poll $poll, EntityManagerInterface $em): Response {
        $form = $this->createForm(PollType::class, $poll);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_polls_index');
        }

        return $this->render('back/poll/edit.html.twig', [
            'poll' => $poll,
            'form' => $form->createView()
        ]);
    }

   /**
    * @Route("/{id}/delete", name="admin_polls_delete", methods={"POST"})
    */
        public function delete(Request $request, Poll $poll, EntityManagerInterface $em): Response {
            if ($this->isCsrfTokenValid('delete'.$poll->getId(), $request->request->get('_token'))) {
        // Supprimer toutes les réponses associées avant de supprimer le sondage
                foreach ($poll->getAnswers() as $answer) {
            $em->remove($answer);
        }
        // Supprimer le sondage
        $em->remove($poll);
        $em->flush();
    }

    return $this->redirectToRoute('admin_polls_index');
}

    /**
     * Affiche les réponses d'un sondage spécifique.
     * (NOTE : Cette méthode nécessite une logique supplémentaire pour récupérer et afficher les réponses.)
     *
     * @Route("/{id}/answers", name="admin_polls_answers")
     *
     * @param Poll $poll Le sondage dont on veut voir les réponses.
     *
     * @return Response La vue affichant les réponses du sondage.
     */
    public function answers(Poll $poll): Response {
        return $this->render('back/answer/answer.html.twig', [
            'poll' => $poll
        ]);
    }
}
