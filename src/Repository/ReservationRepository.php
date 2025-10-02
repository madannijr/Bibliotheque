<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Enum\StatutReservationType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function effectuerReservation(Utilisateur $utilisateur, Livre $livre)
    {
        $reservation = new Reservation();
        $reservation->setUtilisateur($utilisateur);
        $reservation->setLivre($livre);
        $reservation->setDateReservation(new \DateTime());
        $reservation->setStatut(StatutReservationType::EN_ATTENTE);

        $entityManger = $this->getEntityManager();
        $entityManger->persist($reservation);
        $entityManger->flush();
    }

    public function annulerReservation(Reservation $reservation)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($reservation);
        $entityManager->flush();
    }

    public function getReservationsByUser(Utilisateur $utilisateur)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.utilisateur = :utilisateur')
            ->setParameter('utilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
