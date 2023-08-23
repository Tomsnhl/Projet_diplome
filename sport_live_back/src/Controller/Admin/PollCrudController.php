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

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
