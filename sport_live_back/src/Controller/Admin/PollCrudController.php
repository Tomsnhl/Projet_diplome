<?php

namespace App\Controller\Admin;

use App\Entity\Poll;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PollCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Poll::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),  // Hide on form as it's auto-generated
            TextField::new('content', 'Content'),
            AssociationField::new('user', 'User'),
            AssociationField::new('answers', 'Answers')->onlyOnDetail(), // Show only on details page
        ];
    }

}