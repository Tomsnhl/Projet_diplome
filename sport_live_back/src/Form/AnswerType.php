<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType; // Importation de la classe TextType
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, [
                'label' => 'Réponse',
                'attr' => [
                    'placeholder' => 'Entrez la réponse ici'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // Cette fonction configure les options pour le formulaire, 
        // en indiquant que ce formulaire est lié à l'entité Answer.
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
