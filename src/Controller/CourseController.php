<?php

namespace App\Controller;

use App\Entity\CourseHeader;
use App\Entity\CourseHeaderDetails;
use App\Form\CourseFormType;
use App\Form\CourseModuleFormType;
use App\Repository\CourseHeaderDetailsRepository;
use App\Repository\CourseHeaderRepository;
use Container4db5V3Z\getUniqidNamerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'app_course')]
    public function index(): Response
    {
        return $this->render('course/index.html.twig', [
            'controller_name' => 'CourseController',
        ]);
    }

    #[Route('/course/create-course', name: 'app_create_course')]
    public function createCourse(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new CourseHeader();
        $form = $this->createForm(CourseFormType::class,$course);
        $form ->handleRequest($request);

        if($form ->isSubmitted() && $form ->isValid()){
            /*todo:check if classId exists if not return error*/
            $course ->setClassId($form->get('ClassId')->getData());
            $course ->setCourseDuration($form->get('CourseDuration')->getData());
            $course->setCourseName($form->get('CourseName')->getData());
            $course->setCourserTutor($this->getUser()->getUserIdentifier());
            $course->setIsActive($form->get('IsActive')->getData());
            $course ->setCourseCode($form->get('CourseCode')->getData());

            try{

                $entityManager ->persist($course);
                $entityManager->flush();
                $course_id = $course->getId();

                return  new RedirectResponse($this->generateUrl('app_populate_course',['courseId'=>$course_id]));
            }catch (\Exception $e){
                $this->addFlash('fail',$e->getMessage());
            }
            $this ->addFlash('success','Course created');
        }
        return $this->render('course/create_course.html.twig', [
            'controller_name' => 'CourseController',
            'courseForm' => $form->createView()
        ]);
    }

    #[Route('/course-module-populate/{courseId}', name: 'app_populate_course')]
    public function addCourseModule(
        Request $request,
        EntityManagerInterface $entityManager,
        CourseHeaderRepository $repository,
        string $courseId
    ): Response
    {
        $course_module = new CourseHeaderDetails();
        $form = $this->createForm(CourseModuleFormType::class,$course_module);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $course_module->setCourseId($courseId);
            $course_module->setModuleContent($form ->get('ModuleContent')->getData());
            //$course_module->setModuleDuration($form ->get('ModuleDuration')->getData());
            $course_module ->setAttachmentFile($form ->get('AttachmentFile')->getData());
            $course_module->setModuleContent($form ->get('ModuleContent')->getData());
            $course_module->setModuleDescription($form->get('ModuleDescription')->getData());
            try {
                $entityManager ->persist($course_module);
                $entityManager ->flush();
                $this->addFlash('success','course module added, you can add another one');
            }catch (\Exception $e) {
                $this->addFlash('fail',$e->getMessage());
            }
        }
        $courseInfo = $repository->find($courseId);
        return $this->render('course/course_module_populate_info.html.twig', [
            'controller_name' => 'CourseController',
            'courseModuleForm' => $form ->createView(),
            'course' =>$courseInfo
        ]);
    }

    #[Route('/course-header/{user_role}')]
    public function courseHeader(CourseHeaderRepository $courseHeaderRepository, string $user_role = null): Response
    {
        $courses = $courseHeaderRepository ->findAll();
        return $this->render('course/course_header_private.html.twig', [
            'controller_name' => 'CourseController',
            'courses'=> $courses
        ]);
    }

    #[Route('/course-header-details/{user_role}/{course_id}', name: 'app_course_header_details')]
    public function courseHeaderDetails(
        CourseHeaderDetailsRepository $courseHeaderDetailsRepository,
        CourseHeaderRepository $courseHeaderRepository,
        string $course_id,
        string $user_role,
        UploaderHelper $uploaderHelper,
    ): Response
    {
        $course_details_query = $courseHeaderDetailsRepository->findBy(array("CourseId" => $course_id));
        $course = $courseHeaderRepository->find($course_id);

        $data =  [
            'controller_name' => 'CourseController',
            'courseHeaderDetail' =>$course_details_query,
            'courseHeader' =>$course,
            'courseModules' => $course_details_query

        ];
        return match ($user_role) {
            'ROLE_STUDENT' => $this->render('course/course_header_details_client.html.twig',$data),
            default => $this->render('course/course_header_details_private.html.twig',$data),
        };
    }
}
