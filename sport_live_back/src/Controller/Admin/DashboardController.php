<?php

namespace App\Controller\Admin;

use App\Repository\AnswerRepository;
use App\Repository\MessageRepository;
use App\Repository\PollRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $answerRepository;
    private $messageRepository;
    private $pollRepository;
    private $userRepository;

    public function __construct(AnswerRepository $answerRepository, MessageRepository $messageRepository, PollRepository $pollRepository, UserRepository $userRepository)
    {
        $this->answerRepository = $answerRepository;
        $this->messageRepository = $messageRepository;
        $this->pollRepository = $pollRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('back/admin/admin_dashboard.html.twig', [
            'answers' => $this->answerRepository->findAll(),
            'messages' => $this->messageRepository->findAll(),
            'polls' => $this->pollRepository->findAll(),
            'users' => $this->userRepository->findAll()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sport Live Back');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Sondages', 'fas fa-poll', Poll::class);

    }
}
