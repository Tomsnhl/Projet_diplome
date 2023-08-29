<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Poll;
use App\Entity\Message;
use App\Form\PollType; // Importez PollType
use App\Form\MessageType;
use DateTimeImmutable;
use App\Repository\PollRepository;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    // Définition des propriétés
    private $answerRepository;
    private $messageRepository;
    private $pollRepository;
    private $userRepository;
    private $entityManager;
    private $passwordHasher;

    // Constructeur pour injecter les dépendances
    public function __construct(
        AnswerRepository $answerRepository,
        MessageRepository $messageRepository,
        PollRepository $pollRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->answerRepository = $answerRepository;
        $this->messageRepository = $messageRepository;
        $this->pollRepository = $pollRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Dashboard principal.
     * @Route("/admin", name="admin")
     */
    public function dashboard(Request $request): Response
    {
        // Création d'un nouvel utilisateur et formulaire associé
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Traitement du formulaire d'utilisateur
        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash('success', 'Utilisateur ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        // Création d'un nouveau message et formulaire associé
        $message = new Message();
        $message->setSentDate(new \DateTimeImmutable('now'));
        $message->setIsApproved('false');
        $message->setIsDeleted('false');
        $message->setUser($this->getUser());
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        // Traitement du formulaire de message
        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $this->entityManager->persist($message);
            $this->entityManager->flush();
            $this->addFlash('success', 'Message ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        // Création d'un nouveau sondage et formulaire associé
        $poll = new Poll();
        $pollForm = $this->createForm(PollType::class, $poll);
        $pollForm->handleRequest($request);

        // Traitement du formulaire de sondage
        if ($pollForm->isSubmitted() && $pollForm->isValid()) {
            $this->entityManager->persist($poll);
            $this->entityManager->flush();
            $this->addFlash('success', 'Sondage ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        // Rendre la vue avec les données et les formulaires
        return $this->render('back/admin/admin_dashboard.html.twig', [
            'answers' => $this->answerRepository->findAll(),
            'messages' => $this->messageRepository->findAll(),
            'polls' => $this->pollRepository->findAll(),
            'users' => $this->userRepository->findAll(),
            'userForm' => $form->createView(),
            'messageForm' => $messageForm->createView(),
            'pollForm' => $pollForm->createView() // Ajout du formulaire de sondage à la vue
        ]);
    }

    // Configuration du tableau de bord
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sport Live Back')
            ->disableUrlSignatures();
    }

    // Configuration des éléments du menu
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Sondages', 'fas fa-poll', Poll::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Messages', 'fas fa-user', Message::class);
    }
}
