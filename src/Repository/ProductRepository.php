<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByOrder($filter)
    {
        $qb = $this->createQueryBuilder('p');

        if($filter == 'asc') {
            $qb->orderBy('p.createdAt', 'ASC');
        } else {
            $qb->orderBy('p.createdAt', 'DESC');
        }

        $qb->where('p.quantity > 0');
        $qb->where('p.published = 1');

        return $qb->getQuery()->getResult();
    }

    public function getProductByUser($user)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->where('p.seller = :user');
        $qb->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }

    public function updateQuantity($product, $quantity)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->update();
        $qb->set('p.quantity', ':quantity');
        $qb->setParameter('quantity', $quantity);
        $qb->where('p.id = :id');
        $qb->setParameter('id', "$product");
        
        return $qb->getQuery()->getResult();
    }


//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
