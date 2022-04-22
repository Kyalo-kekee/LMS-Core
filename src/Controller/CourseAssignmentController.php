<?php

namespace App\Controller;

use App\Entity\AssignmentHeader;
use App\Form\AssignmentFormType;
use App\Repository\AssignmentHeaderRepository;
use App\Repository\MshuleUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseAssignmentController extends AbstractController
{
    #[Route('/course/assignment', name: 'app_course_assignment')]
    public function index(): Response
    {
        return $this->render('course_assignment/index.html.twig', [
            'controller_name' => 'CourseAssignmentController',
        ]);
    }

    #[Route('/assignment-populate-info/',name: 'app_create_assignment')]
    public function createAssignment(Request $request , EntityManagerInterface $entityManager): Response
    {
        $assignment = new AssignmentHeader();
        $form = $this->createForm(AssignmentFormType::class,$assignment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            try {

                $assignment ->setAssignmentName($form->get('AssignmentName')->getData());
                $assignment ->setContent($form->get('Content')->getData());
                $assignment ->setModuleId($form->get('ModuleId')->getData());
                $assignment ->setSubmitBefore($form->get('SubmitBefore')->getData());
                $assignment ->setAttachmentFile($form->get('AttachmentFile')->getData());
                $assignment->setUpdatedAt( new \DateTimeImmutable());
                $assignment->setCreatedBy($this->getUser()->getUserIdentifier());
                $assignment->setClassId($form->get('ClassId')->getData());

                $entityManager ->persist($assignment);
                $entityManager->flush();
                $this->addFlash('success','Assignment Published, student can access it via the dashboard');
            }catch (\Exception $e){
                $this->addFlash('fail', $e->getMessage());
            }
        }
        return $this->render('course_assignment/assignment_populate_info.html.twig', [
            'controller_name' => 'CourseAssignmentController',
            'assignmentForm' => $form ->createView()
        ]);
    }

    #[Route('/assignment-header/', name: 'app_assignment_header')]
    public  function assignmentHeader(AssignmentHeaderRepository $repository): Response
    {
        return $this->render('course_assignment/assignment_header.html.twig', [
            'controller_name' => 'CourseAssignmentController',
            'assignments' => $repository ->findAll()
        ]);
    }

    #[Route('/student-assignments',name: 'app_student_assignment')]
    public function studentAssignments(
        AssignmentHeaderRepository $assignmentHeaderRepository,
        MshuleUserRepository $userRepository)
    {
        $roles = $this ->getUser() ->getRoles();

        if(in_array('ROLE_STUDENT',$roles))
        {
            $user = $userRepository ->createQueryBuilder('USER')
                ->where('USER.username = :username')
                ->setParameters(new ArrayCollection(array(
                    new Parameter('username',$this->getUser()->getUserIdentifier())
                )))->getQuery();
            $client= $user->getResult();
            $classId = $client[0] ->getClassId();

            $assignments = $assignmentHeaderRepository ->createQueryBuilder('A')
                ->where('A.ClassId = :classId')
                ->setParameter('classId', $classId)
                ->getQuery()
                ->getResult();

            return $this->render('course_assignment/assignment_header_student.html.twig', [
                'controller_name' => 'CourseAssignmentController',
                'assignments' => $assignments
            ]);
        }
    }

}
