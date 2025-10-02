<?php

namespace App\Controller\Admin;

use App\Entity\Livre;
use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LivreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('Titre'),
            TextField::new('Auteur'),
            TextField::new('ISBN'),
            TextField::new('Genre'),
            IntegerField::new('Annee_De_Publication'),
            TextField::new('Description'),
            IntegerField::new('NombresExemplairesDisponibles'),
            ImageField::new('image')
                ->setBasePath('public/uploads')
                ->setUploadDir('public/uploads')
                ->setRequired(true)
               ->onlyOnForms(),
            AssociationField::new ('categorie'),
        ];
    }

}
