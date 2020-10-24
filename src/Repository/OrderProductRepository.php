<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }
//select o.id, o.marketplace, o.created_at, p.label, p.price, p.ref, u.firstname, u.lastname, u.email, a.street, a.zip, a.city
//from order_product
//join `order` o on o.id = order_product.orders_id
//join product p on p.id = order_product.product_id
//join users u on u.id = o.users_id
//join address a on a.id = u.address_id
    public function findAllorder()
    {
        return $this->createQueryBuilder('op')
            ->select('op.id', 'o.marketplace', 'o.created_at','p.label', 'p.price', 'p.ref', 'op.qte','u.firstname', 'u.lastname')
            ->join('op.orders', 'o')
            ->join('o.users', 'u')
            ->join('op.products', 'p')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneOrder($orderId)
    {
        return $this->createQueryBuilder('op')
            ->select(
                'o.id',
                'o.created_at',
                'o.marketplace',
                'p.label',
                'p.price',
                'p.ref',
                'op.qte',
                'u.firstname',
                'u.lastname',
                'u.email',
                'a.street',
                'a.zip',
                'a.city'
            )
            ->join('op.orders', 'o')
            ->join('o.users', 'u')
            ->join('op.products', 'p')
            ->join('u.address', 'a')
            ->andWhere('op.id = :val')
            ->setParameter('val', $orderId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    // /**
    //  * @return OrderProduct[] Returns an array of OrderProduct objects
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
    public function findOneBySomeField($value): ?OrderProduct
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
