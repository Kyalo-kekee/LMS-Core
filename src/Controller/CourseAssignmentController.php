<?php

namespace App\Controller;

use App\Entity\AssignmentHeader;
use App\Entity\StudentAssignmentHeader;
use App\Form\AssignmentFormType;
use App\Form\StudentAssignmentSubmissionFormType;
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

    #[Route('/student-assignments/{action}/{module_id}', name: 'app_student_assignment',requirements: ['module_id' =>'.+'])]
    public function studentAssignments(
        AssignmentHeaderRepository $assignmentHeaderRepository,
        MshuleUserRepository       $userRepository,
        Request                    $request,
        EntityManagerInterface     $entityManager,
        string                     $action = null,
        string                     $module_id = null,
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
            if ($form->isSubmitted() && $form->isValid()) {
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
                } catch (\Exception $e) {
                    $this->addFlash('fail', 'An database error occurred please contact admin or try resubmitting');
                    $this->addFlash('fail', 'Error info - ' . $e->getMessage());
                }
            }
        }

        if (in_array('ROLE_STUDENT', $roles)) {

            $assignments = $assignmentHeaderRepository->createQueryBuilder('A')
                ->where('A.ClassId = :classId')
                ->setParameter('classId', $classId)
                ->getQuery()
                ->getResult();

            return $this->render('course_assignment/assignment_header_student.html.twig', [
                'controller_name' => 'CourseAssignmentController',
                'assignments' => $assignments,
                'submitForm'=>$form ->createView(),
                'module_id' =>$module_id
            ]);
        }
    }

}
