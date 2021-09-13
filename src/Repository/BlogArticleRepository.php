<?php

namespace App\Repository;

use App\Entity\BlogArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BlogArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogArticle[]    findAll()
 * @method BlogArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BlogArticle::class);
    }

    // /**
    //  * @return BlogArticle[] Returns an array of BlogArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogArticle
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    function findRechercheDQL($recherche)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.titleArticle LIKE :val OR a.contentArticle LIKE :val OR a.category LIKE :val ')
            ->setParameter('val', "%$recherche%")
            ->orderBy('a.dateModification', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function listeArticle()
    {
        return $this
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery() 
            ->getResult() 
            ;
    }
}
