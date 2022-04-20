<?php

namespace App\Controller;

use App\Entity\AssignmentHeader;
use App\Form\AssignmentFormType;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/assignment-populate-info',name: 'app_create_assignment')]
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
                $assignment->setUpdatedAt( new \DateTimeImmutable());
                $assignment->setClassId($form->get('ClassId')->getData());

                $entityManager ->persist($assignment);
                $entityManager->flush();
            }catch (\Exception $e){
                $this->addFlash('fail', $e->getMessage());
            }
        }
        return $this->render('course_assignment/assignment_populate_info.html.twig', [
            'controller_name' => 'CourseAssignmentController',
        ]);
    }

    public function submittedAssignments()
    {

    }
}
