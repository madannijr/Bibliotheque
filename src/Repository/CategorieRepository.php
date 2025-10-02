<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    // requete pour associer chaque categorie a une image
   /*public function findRandCategorie()
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c.nom as nom_categorie, c.id as id, MAX(l.image) as image_livre')
            ->leftJoin('c.livres', 'l')
            ->groupBy('c.id')
            ->getQuery();

        return $qb->getResult(); */

        public function findRandCategorie(): array
    {
        $sql = $this->createQueryBuilder('c')
            ->select('c.nom as nom_categorie,c.id as id')
            ->addSelect('(SELECT MAX(lr.image) FROM App\Entity\Livre lr WHERE lr.categorie = c.id) as livre_image')
            ->leftJoin('c.livres', 'l')
            ->groupBy('c.id')
            ->getQuery();

        return $sql->getResult();
    }

   // }

//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
