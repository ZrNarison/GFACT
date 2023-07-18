<?php

namespace App\Repository;

use App\Entity\UpdatePassword;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UpdatePassword>
 *
 * @method UpdatePassword|null find($id, $lockMode = null, $lockVersion = null)
 * @method UpdatePassword|null findOneBy(array $criteria, array $orderBy = null)
 * @method UpdatePassword[]    findAll()
 * @method UpdatePassword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UpdatePasswordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UpdatePassword::class);
    }

    public function add(UpdatePassword $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UpdatePassword $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return UpdatePassword[] Returns an array of UpdatePassword objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UpdatePassword
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
