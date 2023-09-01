<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture 
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = [
            [
                'firstname' => 'Admin',
                'lastname' => 'Un',
                'alias' => 'adminun',
                'email' => 'adminun@exemple.com',
                'password' => 'kevin'
            ],
            
            // Vous pouvez ajouter plus d'admins ici.
        ];

        foreach ($user as $userData) {
            $user = new User();
            $user->setFirstname($userData['prenom']);
            $user->setLastname($userData['nom']);
            $user->setAlias($userData['pseudo']);
            $user->setEmail($userData['email']);
            $user->setRoles(['ROLE_ADMIN']); // Définir le rôle en tant qu'admin

            // Encoder le mot de passe
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userData['password']
            ));

            $manager->persist($user);
        }

        $manager->flush();
    }
}