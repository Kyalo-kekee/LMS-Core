<?php

namespace App\Repository;

use App\Entity\AssignmentHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssignmentHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssignmentHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssignmentHeader[]    findAll()
 * @method AssignmentHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssignmentHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssignmentHeader::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AssignmentHeader $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(AssignmentHeader $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public  function getModuleAssignment(string $module_id)
    {
        return $this ->createQueryBuilder('ah')
            ->where('ah.ModuleId = :moduleId')
            ->setParameter('moduleId',$module_id)
            ->getQuery() ->getResult();
    }

    public function  getClassAssignments($class_id)
    {
        return $this ->createQueryBuilder('A')
            ->where('A.ClassId = :classId')
            ->setParameter('classId', $class_id)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return AssignmentHeader[] Returns an array of AssignmentHeader objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AssignmentHeader
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
