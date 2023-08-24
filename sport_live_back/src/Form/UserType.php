<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                "label" => "L'email",
                "attr" => [
                    "placeholder" => "Email de l'utilisateur"
                ]
            ]);

            // Je souhaite ici ne pas afficher le champ password si je suis en mode edit
            // En effet un admin n'est pas censé pouvoir modifier le mot de passe de quelqu'un d'autre
            // Je vais donc utiliser une option custom_option qui me permettra de savoir si je suis en mode edit ou non
            // Les options customs ce definissent plus bas dans la méthode configureOptions
            // Pour les utiliser il suffit lors de la création du formulaire de passer un tableau en deuxième paramètre de la méthode createForm
            if($options["custom_option"] !== "edit"){
                $builder
                // Je souhaite ici utiliser le champ repeated pour avoir deux champs password
                // https://symfony.com/doc/current/reference/forms/types/repeated.html
                    ->add('password',RepeatedType::class,[
                        "help" => "Le mot de passe doit contenir au moins 4 caractères",
                        // D'ou ici l'interet de mettre une contrainte directement dans le form vu que le mot de passe s'affichera conditionnellement
                        "constraints" => [
                            new Length([
                                "min" => 4,
                                "minMessage" => "Le mot de passe doit contenir au moins 4 caractères"
                            ])
                        ],
                        "type" => PasswordType::class,
                        'invalid_message' => 'Les deux champs doivent être identique',
                        'required' => true,
                        'first_options'  => ['label' => 'Le mot de passe',"attr" => ["placeholder" => "*****"]],
                        'second_options' => ['label' => 'Répétez le mot de passe',"attr" => ["placeholder" => "*****"]],
                    ]);
            }
            $builder
                ->add('roles',ChoiceType::class,[
                    "label" => "Privilèges",
                    "choices" => [
                        "Manager" => "ROLE_MANAGER",
                        "Admin" => "ROLE_ADMIN"
                    ],
                    "multiple" => true,
                    "expanded" => true
                ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'custom_option' => "default",
        ]);
    }
}
