<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Entity\User;
use App\Form\UserType; // Assurez-vous d'avoir ce formulaire UserType.
use App\Form\MessageType;
use App\Repository\AnswerRepository;
use App\Repository\MessageRepository;
use App\Repository\PollRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $answerRepository;
    private $messageRepository;
    private $pollRepository;
    private $userRepository;
    private $entityManager;

    public function __construct(AnswerRepository $answerRepository, MessageRepository $messageRepository, PollRepository $pollRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->answerRepository = $answerRepository;
        $this->messageRepository = $messageRepository;
        $this->pollRepository = $pollRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function dashboard(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        $message = new Message();
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $this->entityManager->persist($message);
            $this->entityManager->flush();

            $this->addFlash('success', 'Message ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        return $this->render('back/admin/admin_dashboard.html.twig', [
            'answers' => $this->answerRepository->findAll(),
            'messages' => $this->messageRepository->findAll(),
            'polls' => $this->pollRepository->findAll(),
            'users' => $this->userRepository->findAll(),
            'userForm' => $form->createView(),// Passez le formulaire à votre template
            'messageForm' => $messageForm->createView(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sport Live Back')
            ->disableUrlSignatures(); // Désactivation des signatures d'URL
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Sondages', 'fas fa-poll', Poll::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Messages','fas fa-user', Message::class);
    }
}
