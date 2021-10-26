<?php

namespace App\Repository;

use App\Entity\PlayerDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayerDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerDetails[]    findAll()
 * @method PlayerDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerDetails::class);
    }

    public function findByTeamAndPlayer($options)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.team = :team')
            ->setParameter('team', $options['team'])
            ->andWhere('d.player = :player')
            ->setParameter('player', $options['player'])
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    // /**
    //  * @return PlayerDetails[] Returns an array of PlayerDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerDetails
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
