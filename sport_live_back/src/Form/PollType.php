<?php

namespace App\Form;

use App\Entity\Poll;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Ajout du champ pour la question du sondage
        $builder
            ->add('content', TextType::class, [
                'label' => 'Question du sondage', // Label du champ
                'attr' => [
                    'placeholder' => 'Entrez la question ici' // Placeholder pour le champ
                ]
            ]);

        // Supposons que chaque sondage a plusieurs réponses
        // Nous utilisons le type CollectionType pour gérer ces relations.
        $builder
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class, // 
                'entry_options' => ['label' => false], // Pas de label pour chaque réponse individuelle
                'allow_add' => true, // Autoriser l'ajout de nouvelles réponses
                'allow_delete' => true, // Autoriser la suppression de réponses
                'by_reference' => false, // Cela garantit que on peut ajouter/supprimer des réponses
                'label' => 'Réponses' // Label pour la collection de réponses
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Reliez ce formulaire à l'entité Poll
        $resolver->setDefaults([
            'data_class' => Poll::class,
        ]);
    }
}
