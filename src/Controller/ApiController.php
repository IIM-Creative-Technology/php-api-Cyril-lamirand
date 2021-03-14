<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Classroom;
use App\Entity\Course;
use App\Entity\Promotion;
use App\Entity\Result;
use App\Entity\Student;
use App\Entity\Teacher;

use App\Form\ClassroomType;
use App\Form\PromotionType;
use App\Repository\ClassroomRepository;
use App\Repository\CourseRepository;
use App\Repository\PromotionRepository;
use App\Repository\ResultRepository;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $objectManager;
    /**
     * @var User
     */
    private $user;
    /**
     * @var classroomRepository
     */
    private $classroomRepository;
    /**
     * @var courseRepository
     */
    private $courseRepository;
    /**
     * @var promotionRepository
     */
    private $promotionRepository;
    /**
     * @var resultRepository
     */
    private $resultRepository;
    /**
     * @var studentRepository
     */
    private $studentRepository;
    /**
     * @var teacherRepository
     */
    private $teacherRepository;

    /**
     * ApiController constructor.
     * @param EntityManagerInterface $objectManager
     * @param RequestStack $request
     */
    public function __construct(EntityManagerInterface $objectManager, RequestStack $request)
    {
        $this->objectManager = $objectManager;
        $authorization = $request->getCurrentRequest()->headers->get('authorization');
        $apiToken = str_replace('Bearer ', '', $authorization);
        $user = $this->objectManager->getRepository(User::class)->findOneBy([
            'api_token' => $apiToken,
        ]);
        if (!$user instanceof User) {
            throw new HttpException(401, 'Unauthorized');
        }
        $this->user = $user;
        // Repository
        $this->classroomRepository  = $objectManager->getRepository(Classroom::class);
        $this->courseRepository     = $objectManager->getRepository(Course::class);
        $this->promotionRepository  = $objectManager->getRepository(Promotion::class);
        $this->resultRepository     = $objectManager->getRepository(Result::class);
        $this->studentRepository    = $objectManager->getRepository(Student::class);
        $this->teacherRepository    = $objectManager->getRepository(Teacher::class);
    }

    /**
     * @param $collection
     * @return JsonResponse
     */
    public function returnResponse($collection): JsonResponse
    {
        $response = new JsonResponse($collection);
        // Useful when the API is on Heroku / Online.
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function returnBad($case): JsonResponse
    {
        $fixtures = "You probably forgot to use this command : php bin/console doctrine:fixtures:load";

        switch ($case) {
            case "classroom":
                $msg = "Wrong Classroom !";
                $classrooms = $this->classroomRepository->findAll();
                $arrayClassrooms = array();
                if (!empty($classrooms)) {
                    foreach ($classrooms as $classroom) {
                        array_push($arrayClassrooms, [
                            'id'    => $classroom->getId(),
                            'label' => $classroom->getLabel()
                        ]);
                    }
                    $collection = array(
                        "error" => $msg,
                        "classrooms_available" => $arrayClassrooms
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            case "promotion":
                $msg = "Wrong Promotion !";
                $promotions = $this->promotionRepository->findAll();
                $arrayPromotions = array();
                if (!empty($promotions)) {
                    foreach ($promotions as $promotion) {
                        array_push($arrayPromotions, [
                           "id"     => $promotion->getId(),
                           "start"  => $promotion->getStart(),
                           "end"    => $promotion->getEnd()
                        ]);
                    }
                    $collection = array(
                        "error" => $msg,
                        "promotions_available" => $arrayPromotions
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            case "course":
                $msg = "Wrong Course !";
                $courses = $this->courseRepository->findAll();
                $arrayCourses = array();
                if (!empty($courses)) {
                    foreach ($courses as $course) {
                        array_push($arrayCourses, [
                           "id"     => $course->getId(),
                           "label"  => $course->getLabel(),
                           "start"  => $course->getStart(),
                           "end"    => $course->getEnd(),
                           "teacher" => [
                               "id"         => $course->getTeacher()->getId(),
                               "firstname"  => $course->getTeacher()->getFirstname(),
                               "lastname"   => $course->getTeacher()->getLastname()
                           ],
                           "classroom" => [
                               "id"     => $course->getClassroom()->getId(),
                               "label"  => $course->getClassroom()->getLabel()
                           ],
                           "promotion" => [
                               "id"     => $course->getPromotion()->getId(),
                               "start"  => $course->getPromotion()->getStart(),
                               "end"    => $course->getPromotion()->getEnd()
                           ]
                        ]);
                    }
                    $collection = array(
                        "msg" => $msg,
                        "courses_available" => $arrayCourses
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            case "result":
                $msg = "Wrong Result !";
                $results = $this->resultRepository->findAll();
                $arrayResults = array();
                if (!empty($results)) {
                    foreach ($results as $result) {
                        array_push($arrayResults, [
                           "id"     => $result->getId(),
                           "score"  => $result->getScore(),
                           "student" => [
                               "id"         => $result->getStudent()->getId(),
                               "firstname"  => $result->getStudent()->getFirstname(),
                               "lastname"   => $result->getStudent()->getLastname(),
                           ],
                           "Course" => [
                               "id"     => $result->getCourse()->getId(),
                               "label"  => $result->getCourse()->getLabel(),
                               "start"  => $result->getCourse()->getStart(),
                               "end"    => $result->getCourse()->getEnd()
                           ]
                        ]);
                    }
                    $collection = array(
                        "msg" => $msg,
                        "results_available" => $arrayResults
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            case "student":
                $msg = "Wrong Student !";
                $students = $this->studentRepository->findAll();
                $arrayStudents = array();
                if (!empty($students)) {
                    foreach ($students as $student) {
                        array_push($arrayStudents, [
                            "id"         => $student->getId(),
                            "firstname"  => $student->getFirstname(),
                            "lastname"   => $student->getLastname(),
                            "age"        => $student->getAge(),
                            "entry_date" => $student->getEntryDate(),
                            "classroom" => [
                                "id"    => $student->getClassroom()->getId(),
                                "label" => $student->getClassroom()->getLabel()
                            ],
                            "promotion" => [
                                "id"    => $student->getPromotion()->getId(),
                                "start" => $student->getPromotion()->getStart(),
                                "end"   => $student->getPromotion()->getEnd()
                            ]
                        ]);
                    }
                    $collection = array(
                        "msg" => $msg,
                        "results_available" => $arrayStudents
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            case "teacher":
                $msg = "Wrong Teacher !";
                $teachers = $this->teacherRepository->findAll();
                $arrayTeachers = array();
                if (!empty($teachers)) {
                    foreach ($teachers as $teacher) {
                        array_push($arrayTeachers, [
                            "id"         => $teacher->getId(),
                            "firstname"  => $teacher->getFirstname(),
                            "lastname"   => $teacher->getLastname(),
                            "entry_date" => $teacher->getEntryDate(),
                        ]);
                    }
                    $collection = array(
                        "msg" => $msg,
                        "results_available" => $arrayTeachers
                    );
                    return $this->returnResponse($collection);
                } else {
                    $collection = array(
                        "error" => $msg,
                        "fixtures" => $fixtures
                    );
                    return $this->returnResponse($collection);
                }
            default:
                $collection = array(
                    "error" => "Something went wrong ?!"
                );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->json([
            'message'   => 'You can use this API !',
            'firstname' => $this->user->getFirstname(),
            'lastname'  => $this->user->getLastname(),
            'email'     => $this->user->getEmail(),
            'Token'     => $this->user->getApiToken()
        ]);
    }

    /**
     * @Route("/classrooms/", name="api_classrooms", methods={"GET"})
     * @return Response
     */
    public function allClassrooms(): Response
    {
        $classrooms = $this->classroomRepository->findAll();
        if (!empty($classrooms)) {
            foreach ($classrooms as $classroom) {
                $countStudents = count($classroom->getStudents());
                $collection[] = array(
                    'id'    => $classroom->getId(),
                    'label' => $classroom->getLabel(),
                    'count_student' => $countStudents,
                    'promotion' => [
                        'id'    => $classroom->getPromotion()->getId(),
                        'start' => $classroom->getPromotion()->getStart(),
                        'end'   => $classroom->getPromotion()->getEnd()
                    ]
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("classroom");
        }
    }

    /**
     * @Route("/classroom/new", name="api_classroom_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createClassroom(Request $request): Response
    {
        $promotionId = $request->get("promotion");
        $promotion   = $this->promotionRepository->find($promotionId);
        if (!$promotion instanceof Promotion) {
            return $this->returnBad("promotion");
        } else {
            $classroom = new Classroom();
            $form = $this->createForm(ClassroomType::class, $classroom);
            $form->submit($request->request->all());
            $this->objectManager->persist($classroom);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Classroom Created !",
                "classroom" => [
                    "id"    => $classroom->getId(),
                    "label" => $classroom->getLabel(),
                    "promotion" => [
                        "id"    => $classroom->getPromotion()->getId(),
                        "start" => $classroom->getPromotion()->getStart(),
                        "end"   => $classroom->getPromotion()->getEnd()
                    ]
                ]
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/classroom/{id}", name="api_classroom_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showClassroom($id): Response
    {
        $classroom = $this->classroomRepository->find($id);
        if (!$classroom instanceof Classroom) {
            return $this->returnBad("classroom");
        } else {
            $collection = array(
                "id"    => $classroom->getId(),
                "label" => $classroom->getLabel(),
                "promotion" => [
                    "id"    => $classroom->getPromotion()->getId(),
                    "start" => $classroom->getPromotion()->getStart(),
                    "end"   => $classroom->getPromotion()->getEnd()
                ],
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/classroom/{id}", name="api_classroom_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editClassroom($id, Request $request): Response
    {
        $classroom = $this->classroomRepository->find($id);
        if (!$classroom instanceof Classroom) {
            return $this->returnBad("classroom");
        } else {
            if ($request->request->get("label")) {
                $classroom->setLabel($request->request->get("label"));
            }
            if ($request->request->get("promotion")) {
                $p = $this->promotionRepository->find($request->request->get("promotion"));
                $classroom->setPromotion($p);
            }
            $this->objectManager->persist($classroom);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Classroom edit : Succeed !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/classroom/{id}", name="api_classroom_delete", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteClassroom($id): Response
    {
        $classroom = $this->classroomRepository->find($id);
        if (!$classroom instanceof Classroom) {
            return $this->returnBad("classroom");
        } else {
            $this->objectManager->remove($classroom);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Classroom : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/promotions/", name="api_promotions", methods={"GET"})
     * @return Response
     */
    public function allPromotions(): Response
    {
        $promotions = $this->promotionRepository->findAll();
        if (!empty($promotions)) {
            foreach ($promotions as $promotion) {
                $classrooms = $this->classroomRepository->findBy(["promotion" => $promotion->getId()]);
                $arrayClassrooms = array();
                foreach ($classrooms as $classroom) {
                    $countStudent = count($classroom->getStudents());
                    array_push($arrayClassrooms, [
                        "id"             => $classroom->getId(),
                        "label"          => $classroom->getLabel(),
                        "count_students" => $countStudent
                    ]);
                }
                $collection[] = array(
                  "id" => $promotion->getId(),
                  "start" => $promotion->getStart(),
                  "end" => $promotion->getEnd(),
                  "classrooms" => $arrayClassrooms
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("promotion");
        }
    }

    /**
     * @Route("/promotion/new", name="api_promotion_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createPromotion(Request $request): Response
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->submit($request->request->all());
        $this->objectManager->persist($promotion);
        $this->objectManager->flush();
        $collection = array(
            "msg" => "Promotion Created !",
            "promotion" => [
                "id"    => $promotion->getId(),
                "start" => $promotion->getStart(),
                "end"   => $promotion->getEnd()
            ]
        );
        return $this->returnResponse($collection);
    }

    /**
     * @Route("/promotion/{id}", name="api_promotion_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showPromotion($id): Response
    {
        $promotion = $this->promotionRepository->find($id);
        if (!$promotion instanceof Promotion) {
            return $this->returnBad("promotion");
        } else {
            $collection = array(
                "id"    => $promotion->getId(),
                "start" => $promotion->getStart(),
                "end"   => $promotion->getEnd()
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/promotion/{id}", name="api_promotion_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editPromotion($id, Request $request): Response
    {
        $promotion = $this->promotionRepository->find($id);
        if (!$promotion instanceof Promotion) {
            return $this->returnBad("promotion");
        } else {
            if ($request->request->get("start")) {
                $promotion->setStart($request->request->get("start"));
            }
            if ($request->request->get("end")) {
                $promotion->setEnd($request->request->get("end"));
            }
            $this->objectManager->persist($promotion);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Promotion edit : Succeed !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/promotion/{id}", name="api_promotion_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deletePromotion($id): Response
    {
        $promotion = $this->promotionRepository->find($id);
        if (!$promotion instanceof Promotion) {
            return $this->returnBad("promotion");
        } else {
            $this->objectManager->remove($promotion);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Promotion (id) : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    // TODO : Course (All, Create, Show, Edit, Delete)
    /**
     * @Route("/courses/", name="api_courses", methods={"GET"})
     * @return Response
     */
    public function allCourses(): Response
    {
        // TODO
    }

    /**
     * @Route("/course/new", name="api_course_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createCourse(Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/course/{id}", name="api_course_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showCourse($id): Response
    {
        // TODO
    }

    /**
     * @Route("/course/{id}", name="api_course_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editCourse($id, Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/course/{id}", name="api_course_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteCourse($id): Response
    {
        // TODO
    }

    // TODO : Result (All, Create, Show, Edit, Delete)
    /**
     * @Route("/results/", name="api_results", methods={"GET"})
     * @return Response
     */
    public function allResults(): Response
    {
        // TODO
    }

    /**
     * @Route("/result/new", name="api_result_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createResult(Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/result/{id}", name="api_result_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showResult($id): Response
    {
        // TODO
    }

    /**
     * @Route("/result/{id}", name="api_result_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editResult($id, Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/result/{id}", name="api_result_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteResult($id): Response
    {
        // TODO
    }

    // TODO : Student (All, Create, Show, Edit, Delete)
    /**
     * @Route("/students/", name="api_students", methods={"GET"})
     * @return Response
     */
    public function allStudents(): Response
    {
        // TODO
    }

    /**
     * @Route("/student/new", name="api_student_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createStudent(Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/student/{id}", name="api_student_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showStudent($id): Response
    {
        // TODO
    }

    /**
     * @Route("/student/{id}", name="api_student_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editStudent($id, Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/student/{id}", name="api_student_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteStudent($id): Response
    {
        // TODO
    }

    // TODO : Teacher (All, Create, Show, Edit, Delete)
    /**
     * @Route("/teachers/", name="api_teachers", methods={"GET"})
     * @return Response
     */
    public function allTeachers(): Response
    {
        // TODO
    }

    /**
     * @Route("/teacher/new", name="api_teacher_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createTeacher(Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/teacher/{id}", name="api_teacher_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showTeacher($id): Response
    {
        // TODO
    }

    /**
     * @Route("/teacher/{id}", name="api_teacher_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editTeacher($id, Request $request): Response
    {
        // TODO
    }

    /**
     * @Route("/teacher/{id}", name="api_teacher_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteTeacher($id): Response
    {
        // TODO
    }
}
