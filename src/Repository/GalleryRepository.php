<?php

namespace App\Repository;

use App\Entity\Gallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Gallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gallery[]    findAll()
 * @method Gallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryRepository extends ServiceEntityRepository
{
    public function findAllArtist() : array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT `artist` FROM `gallery` WHERE 1 GROUP BY `artist`;";
        // $sql = '
        // SELECT * FROM product p
        // WHERE p.price > :price
        // ORDER BY p.price ASC
        // ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

    // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Gallery::class);
    }

    // /**
    //  * @return Gallery[] Returns an array of Gallery objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('g')
    ->andWhere('g.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('g.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
    public function findOneBySomeField($value): ?Gallery
    {
    return $this->createQueryBuilder('g')
    ->andWhere('g.exampleField = :val')
    ->setParameter('val', $value)
    ->getQuery()
    ->getOneOrNullResult()
    ;
    }
     */

    public function listeImage()
    {
        return $this
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            //->setMaxResults(10)
            ->getQuery() // TRANSFORM DQL EN SQL
            ->getResult() // LANCE LA REQUETE ET RECUPERE LES RESULTATS
        ;
    }

}
