<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param $orderId
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneOrder($orderId)
    {
        return $this->createQueryBuilder('o')
            ->select(
                'o.id',
                'o.created_at',
                'o.marketplace',
                'p.label',
                'p.price',
                'p.ref',
                'o.qte',
                'u.firstname',
                'u.lastname',
                'u.email',
                'a.street',
                'a.zip',
                'a.city'
            )
            //->select('o.id', 'o.created_at', 'o.marketplace', 'p.label', 'p.price', 'p.ref', 'o.qte', 'concat("u.firstname ", "u.lastname") as fullname')
            ->join('o.products', 'p')
            ->join('o.users', 'u')
            ->join('u.address', 'a')
            ->andWhere('o.id = :val')
            ->setParameter('val', $orderId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function search($mots = null)
    {
        return $this->createQueryBuilder('o')
            //->select('o.id', 'o.marketplace', 'o.created_at', 'u.firstname', 'u.lastname')
           // ->join('op.orders', 'o')
            //->join('o.users', 'u')
           // ->join('op.products', 'p')
            ->where('MATCH(o.marketplace) AGAINST (:mots boolean) > 0')
            ->setParameter('mots', $mots)
            ->getQuery()
            ->getResult()
            ;

    }
    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
