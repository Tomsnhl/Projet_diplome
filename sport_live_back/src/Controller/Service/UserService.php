<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Service pour gérer les opérations liées aux utilisateurs.
 */
class UserService
{
    // Ces propriétés stockent une référence vers les services nécessaires.
    private $managerRegistry;
    private $passwordHasher;

    /**
     * Constructeur du service.
     *
     * @param ManagerRegistry $managerRegistry Le registre des gestionnaires de Doctrine (pour interagir avec la base de données).
     * @param UserPasswordHasherInterface $passwordHasher Le service pour hacher les mots de passe.
     */
    public function __construct(ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passwordHasher)
    {
        $this->managerRegistry = $managerRegistry;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Inscription d'un nouvel utilisateur.
     *
     * @param array $data Les données de l'utilisateur à inscrire (e.g. firstname, lastname, email, password, etc.).
     * @return User L'objet User qui a été créé et sauvegardé.
     */
    public function register(array $data): User
    {
        $user = new User();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setAlias($data['alias']);
        $user->setEmail($data['email']);
        $user->setRole('ROLE_USER'); // role par défaut

        // Hachage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Sauvegarde de l'utilisateur dans la base de données
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $user;
    }

    // Ajoutez d'autres méthodes selon les besoins, par exemple pour la connexion (qui utilisera probablement la sécurité intégrée de Symfony)
}
