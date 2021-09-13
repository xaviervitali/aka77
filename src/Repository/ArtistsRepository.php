<?php

namespace App\Repository;

use App\Entity\Artists;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Artists|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artists|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artists[]    findAll()
 * @method Artists[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artists::class);
    }

    // /**
    //  * @return Artists[] Returns an array of Artists objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val'
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     */

    /*
    public function findOneBySomeField($value): ?Artists
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
     */
    public function listeArtists()
    {
        return $this
            ->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->where('a.droit <> 9')
            //->setMaxResults(10)
            ->getQuery() // TRANSFORM DQL EN SQL
            ->getResult();// LANCE LA REQUETE ET RECUPERE LES RESULTATS;
    }

    
    public function findAll()
    {
        return $this
            ->createQueryBuilder('a')
            ->orderBy('a.pseudo', 'ASC')
            ->Where('a.droit = 3')
            ->getQuery() 
            ->getResult() 
        ;
    }
}
