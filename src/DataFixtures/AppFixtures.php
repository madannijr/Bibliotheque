<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Livre;
use App\Enum\StatutLivreType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // stocker les categories dans la variables
        $categorieNom = ['Informatique', 'Mathematiques', 'Ingenieur'];

        $categories = [];
        for ($i = 0; $i < 3; $i++) {
            $categorie = new Categorie();
            $categorie->setNom($categorieNom[$i]);
            $manager->persist($categorie);
            $categories[$i] = $categorie;
        }

// les livres informatiques
        for ($i = 1; $i <= 11; $i++) {
            $livre = new Livre();
            $livre->setTitre("Livre d'informatique numéro " . $i);
            $livre->setAuteur("Auteur de livre d'informatique numéro " . $i);
            $livre->setISBN("ISBN-" . $i);
            $livre->setGenre("Informatique");
            $livre->setDescription("Description du livre d'informatique numéro " . $i);
            $livre->setNombresExemplairesDisponibles(5);
            $livre->setStatut(StatutLivreType::DISPONIBLE);
            $livre->setImage("/images/categories_informatiques/" . $i . ".jpg");
            $livre->setCategorie($categories[0]);
            $manager->persist($livre);
        }

        // pour la categorie mathematiques
        for ($i = 1; $i <= 5; $i++) {
            $livre = new Livre();
            $livre->setTitre("Livre de mathématiques numéro " . $i);
            $livre->setAuteur("Auteur de livre de mathématiques numéro " . $i);
            $livre->setISBN("ISBN-mathematiques-" . $i);
            $livre->setGenre("Mathématiques");
            $livre->setDescription("Description du livre de mathématiques numéro " . $i);
            $livre->setNombresExemplairesDisponibles(5);
            $livre->setStatut(StatutLivreType::DISPONIBLE);
            $livre->setImage("/images/categories_mathematiques/" . $i . ".jpg");
            $livre->setCategorie($categories[1]);
        }

        // pour les ingenieurs
        for ($i = 1; $i <= 2; $i++) {
            $livre = new Livre();
            $livre->setTitre("Livre d'ingénieur numéro " . $i);
            $livre->setAuteur("Auteur de livre d'ingénieur numéro " . $i);
            $livre->setISBN("ISBN-ingenieur-" . $i);
            $livre->setGenre("Ingénierie");
            $livre->setDescription("Description du livre d'ingénieur numéro " . $i);
            $livre->setNombresExemplairesDisponibles(5);
            $livre->setStatut(StatutLivreType::DISPONIBLE); // par exemple, le statut est "disponible"
            // Pour la catégorie "Ingénierie"
            $livre->setImage("/images/categories_ingenieur/" . $i . ".jpg");
            $livre->setCategorie($categories[2]);
            $manager->persist($livre);


            $manager->flush();
        }
    }
}
