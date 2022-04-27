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

    #[Route('/course/create-course/{mode}/{course_id}', name: 'app_create_course')]
    public function createCourse(
        Request                $request,
        EntityManagerInterface $entityManager,
        CourseHeaderRepository $courseHeaderRepository,
        string                 $mode = null,
        string                 $course_id = null
    ): Response
    {
        $course = match ($mode) {
            'edit' => $courseHeaderRepository->find($course_id),
            null => new CourseHeader()

        };

        $form = $this->createForm(CourseFormType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*todo:check if classId exists if not return error*/
            $course->setClassId($form->get('ClassId')->getData());
            $course->setCourseDuration($form->get('CourseDuration')->getData());
            $course->setCourseName($form->get('CourseName')->getData());
            $course->setCourserTutor($this->getUser()->getUserIdentifier());
            $course->setIsActive($form->get('IsActive')->getData());
            $course->setCourseCode($form->get('CourseCode')->getData());

            try {

                $entityManager->persist($course);
                $entityManager->flush();
                $course_id = $course->getId();

                if ($mode) {
                    $this->addFlash('success', 'course updated');
                }

                return new RedirectResponse($this->generateUrl('app_populate_course', ['courseId' => $course_id]));
            } catch (\Exception $e) {
                $this->addFlash('fail', $e->getMessage());
            }

        }
        return $this->render('course/create_course.html.twig', [
            'controller_name' => 'CourseController',
            'courseForm' => $form->createView()
        ]);
    }

    #[Route('/course-module-populate/{courseId}/{mode}', name: 'app_populate_course')]
    public function addCourseModule(
        Request                       $request,
        EntityManagerInterface        $entityManager,
        CourseHeaderRepository        $repository,
        CourseHeaderDetailsRepository $courseHeaderDetailsRepository,
        string                        $courseId,
        string                        $mode = null
    ): Response
    {

        $course_module = match ($mode) {
            'edit' => $courseHeaderDetailsRepository->find($courseId),
            null => new CourseHeaderDetails()
        };
        $form = $this->createForm(CourseModuleFormType::class, $course_module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($mode == 'edit'){
                $course_module->setCourseId($course_module->getCourseId()) ;
            }else{
                $course_module->setCourseId($courseId);
            }

            $course_module->setModuleContent($form->get('ModuleContent')->getData());
            //$course_module->setModuleDuration($form ->get('ModuleDuration')->getData());
            $course_module->setAttachmentFile($form->get('AttachmentFile')->getData());
            $course_module->setModuleContent($form->get('ModuleContent')->getData());
            $course_module->setModuleDescription($form->get('ModuleDescription')->getData());
            try {
                $entityManager->persist($course_module);
                $entityManager->flush();
                ($mode) ? $this->addFlash('success', 'module updated') :
                    $this->addFlash('success', 'course module added, you can add another one');

            } catch (\Exception $e) {
                $this->addFlash('fail', $e->getMessage());
            }
        }

        $courseInfo = $repository->find($courseId);
        if (!empty($course_module)) {
            $courseInfo = $repository->find($course_module->getCourseId());

        }
        return $this->render('course/course_module_populate_info.html.twig', [
            'controller_name' => 'CourseController',
            'courseModuleForm' => $form->createView(),
            'course' => $courseInfo
        ]);
    }

    #[Route('/course-header/{user_role}')]
    public function courseHeader(CourseHeaderRepository $courseHeaderRepository, string $user_role = null): Response
    {
        $courses = $courseHeaderRepository->findAll();
        return $this->render('course/course_header_private.html.twig', [
            'controller_name' => 'CourseController',
            'courses' => $courses
        ]);
    }

    #[Route('/course-header-details/{user_role}/{course_id}', name: 'app_course_header_details')]
    public function courseHeaderDetails(
        CourseHeaderDetailsRepository $courseHeaderDetailsRepository,
        CourseHeaderRepository        $courseHeaderRepository,
        string                        $course_id,
        string                        $user_role,
        UploaderHelper                $uploaderHelper,
    ): Response
    {
        $course_details_query = $courseHeaderDetailsRepository->findBy(array("CourseId" => $course_id));
        $course = $courseHeaderRepository->find($course_id);

        $data = [
            'controller_name' => 'CourseController',
            'courseHeaderDetail' => $course_details_query,
            'courseHeader' => $course,
            'courseModules' => $course_details_query

        ];
        return match ($user_role) {
            'ROLE_STUDENT' => $this->render('course/course_header_details_client.html.twig', $data),
            default => $this->render('course/course_header_details_private.html.twig', $data),
        };
    }
}
