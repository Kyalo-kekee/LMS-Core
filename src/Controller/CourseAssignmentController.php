<?php

namespace App\Controller;

use App\Entity\AssignmentHeader;
use App\Entity\StudentAssignmentHeader;
use App\Form\AssignmentFormType;
use App\Form\StudentAssignmentSubmissionFormType;
use App\Repository\AssignmentHeaderRepository;
use App\Repository\MshuleUserRepository;
use App\Repository\StudentAssignmentHeaderRepository;
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

    #[Route('/assignment-populate-info/', name: 'app_create_assignment')]
    public function createAssignment(Request $request, EntityManagerInterface $entityManager): Response
    {
        $assignment = new AssignmentHeader();
        $form = $this->createForm(AssignmentFormType::class, $assignment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            try {

                $assignment->setAssignmentName($form->get('AssignmentName')->getData());
                $assignment->setContent($form->get('Content')->getData());
                $assignment->setModuleId($form->get('ModuleId')->getData());
                $assignment->setSubmitBefore($form->get('SubmitBefore')->getData());
                $assignment->setAttachmentFile($form->get('AttachmentFile')->getData());
                $assignment->setUpdatedAt(new \DateTimeImmutable());
                $assignment->setCreatedBy($this->getUser()->getUserIdentifier());
                $assignment->setClassId($form->get('ClassId')->getData());

                $entityManager->persist($assignment);
                $entityManager->flush();
                $this->addFlash('success', 'Assignment Published, student can access it via the dashboard');
            } catch (\Exception $e) {
                $this->addFlash('fail', $e->getMessage());
            }
        }
        return $this->render('course_assignment/assignment_populate_info.html.twig', [
            'controller_name' => 'CourseAssignmentController',
            'assignmentForm' => $form->createView()
        ]);
    }

    #[Route('/assignment-header/', name: 'app_assignment_header')]
    public function assignmentHeader(AssignmentHeaderRepository $repository): Response
    {
        return $this->render('course_assignment/assignment_header.html.twig', [
            'controller_name' => 'CourseAssignmentController',
            'assignments' => $repository->findAll()
        ]);
    }

    #[Route('/submitted-assignments/{module_id}',name: 'app_submitted_assignments', requirements: ['module_id' => '.+'])]
    public function submittedAssignment(
        StudentAssignmentHeaderRepository $studentAssignmentHeaderRepository,
        AssignmentHeaderRepository $assignmentHeaderRepository,
        string $module_id): Response
    {
        $submitted =  $studentAssignmentHeaderRepository->createQueryBuilder('std')
            ->where('std.ModuleId = :moduleId')
            ->andWhere('std.Owner = :Owner')
            ->setParameters(new ArrayCollection(
                [
                    new Parameter('moduleId', $module_id),
                    new Parameter('Owner',$this->getUser()->getUserIdentifier())
                ]
            ))->getQuery()->getResult();

        $assignmentHeader = $assignmentHeaderRepository ->createQueryBuilder('ah')
            ->where('ah.ModuleId = :moduleId')
            ->setParameter('moduleId',$module_id)
            ->getQuery() ->getResult();

        return $this->render('course_assignment/submitted_assignment_header.html.twig', [
            'controller_name' => 'CourseAssignmentController',
            'assignments' => $submitted,
            'assignmentHeader' => $assignmentHeader
        ]);
    }

    #[Route('/student-assignments/{action}/{module_id}', name: 'app_student_assignment', requirements: ['module_id' => '.+'])]
    public function studentAssignments(
        AssignmentHeaderRepository        $assignmentHeaderRepository,
        StudentAssignmentHeaderRepository $studentAssignmentHeaderRepository,
        MshuleUserRepository              $userRepository,
        Request                           $request,
        EntityManagerInterface            $entityManager,
        string                            $action = null,
        string                            $module_id = null,
    )
    {
        $roles = $this->getUser()->getRoles();
        $user = $userRepository->createQueryBuilder('USER')
            ->where('USER.username = :username')
            ->setParameters(new ArrayCollection(array(
                new Parameter('username', $this->getUser()->getUserIdentifier())
            )))->getQuery();
        $client = $user->getResult();
        $classId = $client[0]->getClassId();

        $student_assignment = new StudentAssignmentHeader();
        $form = $this->createForm(StudentAssignmentSubmissionFormType::class, $student_assignment);
        $form->handleRequest($request);

        if (!is_null($module_id)) {
            $student_submit_check = $studentAssignmentHeaderRepository->createQueryBuilder('std')
                ->where('std.ModuleId = :moduleId')
                ->andWhere('std.StudentId = :studentId')
                ->setParameters(new ArrayCollection(
                    [
                        new Parameter('moduleId', $module_id),
                        new Parameter('studentId', $client[0]->getStudentId())
                    ]
                ))->getQuery()->getResult();
            /*todo:check for submission deadline*/
            if(empty($student_submit_check)){


                if ($form->isSubmitted() && $form->isValid()) {
                    $assignmentHeader = $assignmentHeaderRepository ->createQueryBuilder('aH')
                        ->where('aH.ModuleId = moduleId')
                        -> setParameter('moduleId', $module_id)
                        ->getQuery()->getResult();

                    $student_assignment ->setTitle($assignmentHeader[0]->getAssignmentName());
                    $student_assignment ->setOwner($assignmentHeader[0]->getCreatedBy());
                    $student_assignment->setClassId($classId);
                    $student_assignment->setAttachmentFile($form->get('AttachmentFile')->getData());
                    $student_assignment->setModuleId($module_id);
                    $student_assignment->setContent($form->get('Content')->getData());
                    $student_assignment->setSubmitDate(new \DateTime('now'));
                    $student_assignment->setUpdatedAt(new \DateTimeImmutable());
                    $student_assignment->setStudentId($client [0]->getStudentId());

                    try {
                        $entityManager->persist($student_assignment);
                        $entityManager->flush();
                        $this->addFlash('success', 'Assignment submitted successfully');
                    } catch (\Exception $e) {
                        $this->addFlash('fail', 'A database error occurred please contact admin or try resubmitting');
                        $this->addFlash('fail', 'Error info - ' . $e->getMessage());
                    }
                }
            }else{
                    $this->addFlash('fail', 'You  already submitted this assignment on: '.
                        $student_submit_check[0]->getSubmitDate()->format('d/m/y h:m:s A'));
            }
        }

        if (in_array('ROLE_STUDENT', $roles)) {

            $assignments = $assignmentHeaderRepository->createQueryBuilder('A')
                ->where('A.ClassId = :classId')
                ->setParameter('classId', $classId)
                ->getQuery()
                ->getResult();

            //get student  submitted assignments
            $student_assignment = $studentAssignmentHeaderRepository->createQueryBuilder('stdA')
                ->where('stdA.StudentId = :studentId')
                ->setParameter('studentId', $client[0]->getStudentId())
                ->getQuery()
                ->getResult();
            return $this->render('course_assignment/assignment_header_student.html.twig', [
                'controller_name' => 'CourseAssignmentController',
                'assignments' => $assignments,
                'submitted' => $student_assignment,
                'submitForm' => $form->createView(),
                'module_id' => $module_id
            ]);
        }
    }

}
