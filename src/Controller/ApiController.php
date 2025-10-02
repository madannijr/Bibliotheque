<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use App\Repository\ReservationRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
   #[Route('/livres', name: 'api_livres')]
    public function apiLivres(LivreRepository $livreRepository): Response
   {
       $livres = $livreRepository->findAll();
       // on transforme en json
       return $this->json($livres, Response::HTTP_OK, [], [
          // voir la definition des groups dans l'entite
           'groups'=>['livre']
       ]);
   }

   #[Route('/categories', name: 'api_categories')]
    public function apiCategories(CategorieRepository $categorieRepository): Response
   {
       $categories = $categorieRepository->findAll();
       // on transforme en json
       return $this->json($categories, Response::HTTP_OK, [
           // voir la definition des groups dans l'entite
           'groups'=>['categorie']
       ]);
   }

    #[Route('/utilisateur', name: 'api_login' )]
    public function apiUser(UtilisateurRepository $utilisateurRepository): Response
    {

        $utilisateur = $utilisateurRepository->findAll();

        return $this->json($utilisateur, Response::HTTP_OK, [],
            [

                'groups' => ['utilisateur']
            ]
        );
    }
    #[Route('/reservation', name:'api_reservation')]
    public function apiReservation(ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->findAll();
        return $this->json($reservation, Response::HTTP_OK, [],
        [
            'groups'=>['reservation']
        ]);
    }

}
