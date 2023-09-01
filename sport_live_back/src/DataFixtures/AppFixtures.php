<?php

namespace App\DataFixtures;

use App\Entity\Poll;
use App\Entity\Answer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture 
{
    public function load(ObjectManager $manager)
    {
        // Créer un certain nombre de sondages (dans cet exemple, 10 sondages).
        // La boucle for s'exécute 10 fois pour créer ces sondages.
        for ($i = 0; $i < 10; $i++) {

            // Création d'une nouvelle instance de l'entité Poll.
            $poll = new Poll();

            // Définition du contenu du sondage. Chaque sondage aura un nom unique grâce à la concaténation de 'Sondage ' et de la valeur courante de $i.
            $poll->setContent('Sondage ' . $i);

            // Demande à Doctrine de préparer la sauvegarde de cette instance de sondage.
            // À ce stade, rien n'est encore envoyé à la base de données.
            $manager->persist($poll);

            // Pour chaque sondage, nous souhaitons créer un certain nombre de réponses (ici, 5 réponses).
            // Nous utilisons donc une autre boucle for pour cela.
            for ($j = 0; $j < 5; $j++) {

                // Création d'une nouvelle instance de l'entité Answer.
                $answer = new Answer();

                // Définition du contenu de la réponse. La réponse est associée à un sondage spécifique grâce à la concaténation.
                $answer->setContent('Réponse ' . $j . ' pour Sondage ' . $i);

                // Définition du rang de la réponse.
                $answer->setRanking($j);

                // Association de la réponse au sondage. Cela suppose que vous avez une relation entre les entités Poll et Answer.
                // Si ce n'est pas le cas, vous pouvez supprimer cette ligne.
                $answer->setPoll($poll);

                // Demande à Doctrine de préparer la sauvegarde de cette instance de réponse.
                $manager->persist($answer);
            }
        }

        // Après avoir préparé toutes les instances de Poll et Answer que nous voulons créer,
        // nous demandons à Doctrine de les sauvegarder effectivement dans la base de données.
        $manager->flush();
    }
}