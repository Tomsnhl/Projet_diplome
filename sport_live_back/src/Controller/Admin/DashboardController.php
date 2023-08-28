<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Poll; 
use App\Form\UserType;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DashboardController extends AbstractDashboardController
{
    private $answerRepository;
    private $messageRepository;
    private $pollRepository;
    private $userRepository;
    private $entityManager;
    private $passwordHasher;

    public function __construct(AnswerRepository $answerRepository, MessageRepository $messageRepository, PollRepository $pollRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->answerRepository = $answerRepository;
        $this->messageRepository = $messageRepository;
        $this->pollRepository = $pollRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher; 
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
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Utilisateur ajouté avec succès.');
            return $this->redirectToRoute('admin');
        }

        return $this->render('back/admin/admin_dashboard.html.twig', [
            'answers' => $this->answerRepository->findAll(),
            'messages' => $this->messageRepository->findAll(),
            'polls' => $this->pollRepository->findAll(),
            'users' => $this->userRepository->findAll(),
            'userForm' => $form->createView()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sport Live Back')
            ->disableUrlSignatures();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Sondages', 'fas fa-poll', Poll::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
    }
}
