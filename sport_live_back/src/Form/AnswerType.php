<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'Réponse', // Label du champ
                'attr' => [
                    'placeholder' => 'Entrez la réponse ici' // Placeholder pour le champ
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Reliez ce formulaire à l'entité Answer
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
