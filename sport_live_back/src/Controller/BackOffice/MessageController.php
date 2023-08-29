<?php

namespace App\Controller\BackOffice;

use App\Entity\Message;
use App\Form\MessageType;  
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/message")
 */
class MessageController extends AbstractController {

    /**
     * Affiche la liste de tous les messages.
     *
     * @Route("/", name="admin_message_index")
     *
     * @param MessageRepository $MessageRepository Le repository pour accéder aux messages.
     *
     * @return Response La vue affichant la liste des messages.
     */
    public function index(MessageRepository $MessageRepository): Response {
        $message = $MessageRepository->findAll();

        return $this->render('back/message/list.html.twig', [
            'messages' => $message
        ]);
    }

    /**
     * Crée un nouveau message.
     *
     * @Route("/new", name="admin_message_new")
     *
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param EntityManagerInterface $em L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour la création de sondage ou la redirection vers la liste des messages.
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
        $message = new message();
        $message->setSentDate(new \DateTimeImmutable("now"));
        $message->setIsApproved("false");
        $message->setIsDeleted("false");
        $message->setUser($this->getUser());
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('back/message/new.html.twig', [
            'messageForm' => $messageForm->createView()
        ]);
    }

    /**
     * Affiche les détails d'un message spécifique.
     *
     * @Route("/{id}", name="admin_message_show")
     *
     * @param message $message Le message à afficher.
     *
     * @return Response La vue affichant les détails du message.
     */
    public function show(message $message): Response {
        return $this->render('back/message/show.html.twig', [
            'messages' => $message
        ]);
    }

    /**
     * Modifie un message spécifique.
     *
     * @Route("/{id}/edit", name="admin_message_edit")
     *
     * @param Request $request L'objet request pour gérer les requêtes HTTP.
     * @param message $message Le message à modifier.
     * @param EntityManagerInterface $em L'entity manager pour gérer les entités.
     *
     * @return Response La vue pour l'édition de message ou la redirection vers la liste des messages.
     */
    public function edit(Request $request, message $message, EntityManagerInterface $em): Response {
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $em->flush();

            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('back/message/edit.html.twig', [
            'messages' => $message,
            'messageForm' => $messageForm->createView()
        ]);
    }

   /**
    * @Route("/{id}/delete", name="admin_message_delete", methods={"POST"})

    * @param Request $request L'objet request pour gérer les requêtes HTTP.
    * @param message $message Le message à modifier.
    * @param EntityManagerInterface $em L'entity manager pour gérer les entités.
    *
    * @return Response La vue pour l'édition de message ou la redirection vers la liste des messages.
    */
        public function delete(Request $request, message $message, EntityManagerInterface $em): Response {
            if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {

        // Supprimer le message
        $em->remove($message);
        $em->flush();
    }

    return $this->redirectToRoute('admin_message_index');
}

}
