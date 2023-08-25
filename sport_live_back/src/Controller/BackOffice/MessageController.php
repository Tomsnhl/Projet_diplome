<?php

namespace App\Controller\BackOffice;

use DateTimeImmutable;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MessageController extends AbstractController
{
    /**
     * @Route("/admin/message", name="app_back_message_list", methods={"GET"})
     */
    public function list(MessageRepository $messageRepository): Response
    {
        return $this->render('back/message/list.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/message/ajouter", name="app_back_message_add", methods={"GET", "POST"})
     */
    public function add(Request $request, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $message->setSentDate(new DateTimeImmutable('now'));
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {

            $messageRepository->add($message, true);

            return $this->redirectToRoute('app_admin_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/message/edit.html.twig', [
            'message' => $message,
            'messageForm' => $messageForm,
        ]);
    }

    /**
     * @Route("/admin/message/{id}", name="app_back_message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('back/message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/admin/message/modifier/{id}", name="app_back_message_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        
        $messageForm = $this->createForm(MessageType::class, $message, ["custom_option" => "edit"]);

        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $messageRepository->add($message, true);

            return $this->redirectToRoute('app_admin_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/message/edit.html.twig', [
            'message' => $message,
            'messageForm' => $messageForm,
        ]);
    }

    /**
     * @Route("/admin/message/supprimer/{id}", name="app_back_message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message, MessageRepository $messageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $messageRepository->remove($message, true);
        }

        return $this->redirectToRoute('app_admin_dashboard_index', [], Response::HTTP_SEE_OTHER);
    }
}
