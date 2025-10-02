<?php

namespace App\Controller;



use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;
use App\Repository\LivreRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Emprunt;
use App\Form\EmpruntType;
use Symfony\Component\Form\FormTypeInterface;



class DefaultController extends AbstractController
{

    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    // Afficher tous les livres
    #[Route('/livres', name: 'app_livres')]
    public function livres(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('default/livres.html.twig', [
            'livres' => $livres
        ]);
    }

    #[Route('/catégories', name: 'app_catégories')]
    public function categories(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('default/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/reserver-livre/{id}', name: 'app_reserver_livre')]
    public function reserverLivre(Livre $livre, ReservationRepository $reservationRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Vérifier si l'utilisateur a déjà réservé ce livre, si oui, rediriger vers la page des livres
        $reservationExistante = $reservationRepository->findOneBy(['utilisateur' => $utilisateur, 'livre' => $livre]);
        if ($reservationExistante) {
            return $this->redirectToRoute('app_livres');
        }

        // Effectuer la réservation du livre pour l'utilisateur connecté
        $reservationRepository->effectuerReservation($utilisateur, $livre);

        // Rediriger vers la page des réservations de l'utilisateur
        return $this->redirectToRoute('app_reservations');
    }

    #[Route('/annuler-reservation/{id}', name: 'app_annuler_reservation')]
    public function annulerReservation(Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Vérifier si l'utilisateur a le droit d'annuler cette réservation, sinon rediriger vers la page des réservations
        if ($reservation->getUtilisateur() !== $utilisateur) {
            return $this->redirectToRoute('app_reservations');
        }

        // Annuler la réservation
        $reservationRepository->annulerReservation($reservation);

        // Rediriger vers la page des réservations de l'utilisateur
        return $this->redirectToRoute('app_reservations');
    }

    #[Route('/reservations', name: 'app_reservations')]
    public function mesReservations(ReservationRepository $reservationRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les réservations de l'utilisateur connecté
        $reservations = $reservationRepository->getReservationsByUser($utilisateur);

        // Retourner le template des réservations avec les réservations de l'utilisateur
        return $this->render('default/reservations.html.twig', [
            'reservations' => $reservations,
        ]);
    }


    // Gerer les emprunts
    #[Route('/emprunts/nouveau', name: 'nouvel_emprunt')]
    public function nouvelEmprunt(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Créer un nouvel objet Emprunt
        $emprunt = new Emprunt();
        $emprunt->setUtilisateur($utilisateur); // Affecter l'utilisateur actuel à l'emprunt

        // Définir la date d'emprunt comme la date actuelle
        $emprunt->setDateEmprunt(new \DateTime());

        // Ajouter un mois à la date actuelle pour la date de retour prévue
        $dateRetourPrevue = new \DateTime();
        $dateRetourPrevue->modify('+1 month');
        $emprunt->setDateDeRetour($dateRetourPrevue);

        // Créer le formulaire en utilisant l'objet Emprunt
        $form = $this->createForm(EmpruntType::class, $emprunt);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'enregistrement de l'emprunt en base de données
            $entityManager->persist($emprunt);
            $entityManager->flush();

            // Rediriger vers une page de confirmation ou autre
            return $this->redirectToRoute('confirmation_emprunt');
        }

        // Afficher le formulaire dans le template
        return $this->render('default/EmpruntForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // Confirmation des Emprunts
    #[Route('/emprunts/confirmation', name: 'confirmation_emprunt')]
    public function confirmation(): Response
    {
        return $this->render('default/confirmation.html.twig');
    }

    // Recuperer la liste des emprunts d'un utilisateur
    #[Route('/mes_emprunts', name: 'mes_emprunts')]
    public function mesEmprunts(): Response
    {
        // Récupérer l'utilisateur connecté
        $utilisateur = $this->getUser();

        // Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer les emprunts de l'utilisateur à partir de sa collection de livres
        $emprunts = $utilisateur->getLivre();

        // Tableau pour stocker les données des emprunts avec les titres des livres
        $empruntsAvecTitres = [];

        foreach ($emprunts as $emprunt) {
            $titreLivre = $emprunt->getLivre()->getTitre();
            $empruntsAvecTitres[] = [
                'emprunt' => $emprunt,
                'titreLivre' => $titreLivre,
            ];
        }

        return $this->render('default/mes_emprunts.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    // traitement et validation du formulaire de  l’upload de fichiers

    #[Route('/ajoutLivres', name:'ajout_livres')]
    public function ajoutLivres(Request $request, EntityManagerInterface $em)
    {
       $livres = new Livre();
       $form = $this->createForm(LivreType::class, $livres);
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()) {
           $em->persist($livres);
           $em->flush();
           return $this->redirectToRoute('app_livres');
       }
       return $this->render('default/ajout_livres.html.twig',[
          'form_livres'=>$form->createView(),
       ]);
    }

}


