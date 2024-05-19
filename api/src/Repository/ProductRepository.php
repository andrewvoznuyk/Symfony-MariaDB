<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
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
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return array
     */
    public function getGroupedProductData(): array
    {
        $qb = $this->createQueryBuilder('product');

        $qb
            ->select('type.typeName AS Type, product.code AS Code, COUNT(product.id) AS TotalItems, SUM(product.price) AS TotalPrice')
            ->leftJoin('product.type', 'type')
            ->groupBy('product.code')
            ->addGroupBy('type.typeName')
            ->orderBy('TotalItems', 'DESC');

        $query = $qb->getQuery();

        return $query->getResult();
    }

}
