<?php

namespace App\Repository;

use App\Entity\Cmd;
use App\Entity\PropertySearch;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Cmd>
 *
 * @method Cmd|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cmd|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cmd[]    findAll()
 * @method Cmd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CmdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cmd::class);
    }

    public function add(Cmd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cmd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Cmd[] Returns an array of Cmd objects
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

//    public function findOneBySomeField($value): ?Cmd
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findCmd(PropertySearch $search):Query
    {
        $query=$this->findAll($search);
        return $query->getQuery();
    }
}
