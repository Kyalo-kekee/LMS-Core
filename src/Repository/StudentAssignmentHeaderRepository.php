<?php

namespace App\Repository;

use App\Entity\StudentAssignmentHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StudentAssignmentHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentAssignmentHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentAssignmentHeader[]    findAll()
 * @method StudentAssignmentHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentAssignmentHeaderRepository extends ServiceEntityRepository
{
    const SUBMITTED_ASSIGNMENT_SUCCESS = 'Assignment submitted successfully';
    const SUBMITTED_ASSIGNMENT_CHECK_FAIL = 'You already made submissions for this assignment';


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentAssignmentHeader::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(StudentAssignmentHeader $entity, bool $flush = true): void
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
    public function remove(StudentAssignmentHeader $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public  function getSubmittedAssignment ( string $module_id ,string $owner)
    {
        return $this ->createQueryBuilder('std')
            ->where('std.ModuleId = :moduleId')
            ->andWhere('std.Owner = :Owner')
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('moduleId', $module_id),
                    new Parameter('Owner',$owner)
                ]
            ))->getQuery()->getResult();
    }

    public function hasSubmittedAssignment (string $module_id,$student_user_identifier)
    {
        return $this -> createQueryBuilder('std')
            ->where('std.ModuleId = :moduleId')
            ->andWhere('std.StudentId = :studentId')
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('moduleId', $module_id),
                    new Parameter('studentId',$student_user_identifier)
                ]
            ))->getQuery()->getResult();
    }



}
