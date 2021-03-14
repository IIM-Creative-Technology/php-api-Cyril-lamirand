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
use App\Form\CourseType;
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
                        "students_available" => $arrayStudents
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
                        "teachers_available" => $arrayTeachers
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
                "msg" => "Classroom (id) : ".$id." has been edited !"
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
                "msg" => "Promotion (id) : ".$id." has been edited !"
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

    /**
     * @Route("/courses/", name="api_courses", methods={"GET"})
     * @return Response
     */
    public function allCourses(): Response
    {
        $courses = $this->courseRepository->findAll();
        if (!empty($courses)) {
            foreach ($courses as $course) {
                $collection[] = array(
                    "id" => $course->getId(),
                    "label" => $course->getLabel(),
                    "start" => $course->getStart(),
                    "end" => $course->getEnd()
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("course");
        }
    }

    /**
     * @Route("/course/new", name="api_course_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createCourse(Request $request): Response
    {
        $teacherR = $request->request->get("teacher");
        $classroomR = $request->request->get("classroom");
        $teacher = $this->teacherRepository->find($teacherR);
        $classroom = $this->classroomRepository->find($classroomR);

        if ($teacher instanceof Teacher && $classroom instanceof Classroom) {
            $course = new Course();
            $course->setLabel($request->request->get("label"));
            $course->setStart(new \DateTime($request->request->get("start")));
            $course->setEnd(new \DateTime($request->request->get("end")));
            $course->setClassroom($classroom);
            $course->setPromotion($classroom->getPromotion());
            $course->setTeacher($teacher);
            $this->objectManager->persist($course);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Course Created !",
                "course" => [
                    "id"    => $course->getId(),
                    "label" => $course->getLabel(),
                    "start" => $course->getStart(),
                    "end"   => $course->getEnd(),
                    "promotion" => [
                        "id" => $course->getPromotion()->getId(),
                        "start" => $course->getPromotion()->getStart(),
                        "end" => $course->getPromotion()->getEnd()
                    ],
                    "classroom" => [
                        "id" => $course->getClassroom()->getId(),
                        "label" => $course->getClassroom()->getLabel()
                    ],
                    "teacher" => [
                        "id" => $course->getTeacher()->getId(),
                        "firstname" => $course->getTeacher()->getFirstname(),
                        "lastname" => $course->getTeacher()->getLastname(),
                        "entry_date" => $course->getTeacher()->getEntryDate()
                    ]
                ]
            );
            return $this->returnResponse($collection);
        } elseif (!$teacher instanceof Teacher && $classroom instanceof Classroom) {
            return $this->returnBad("teacher");
        } elseif ($teacher instanceof Teacher && !$classroom instanceof Classroom) {
            return $this->returnBad("classroom");
        }
    }

    /**
     * @Route("/course/{id}", name="api_course_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showCourse($id): Response
    {
         $course = $this->courseRepository->find($id);
         if (!$course instanceof Course) {
             $this->returnBad("course");
         } else {
             $collection = array(
                 "id"    => $course->getId(),
                 "label" => $course->getLabel(),
                 "start" => $course->getStart(),
                 "end"   => $course->getEnd(),
                 "promotion" => [
                     "id" => $course->getPromotion()->getId(),
                     "start" => $course->getPromotion()->getStart(),
                     "end" => $course->getPromotion()->getEnd()
                 ],
                 "classroom" => [
                     "id" => $course->getClassroom()->getId(),
                     "label" => $course->getClassroom()->getLabel()
                 ],
                 "teacher" => [
                     "id" => $course->getTeacher()->getId(),
                     "firstname" => $course->getTeacher()->getFirstname(),
                     "lastname" => $course->getTeacher()->getLastname(),
                     "entry_date" => $course->getTeacher()->getEntryDate()
                 ]
             );
             return $this->returnResponse($collection);
         }
    }

    /**
     * @Route("/course/{id}", name="api_course_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editCourse($id, Request $request): Response
    {
        $course = $this->courseRepository->find($id);
        if (!$course instanceof Course) {
            $this->returnBad("course");
        } else {
            if ($request->request->get("label")) {
                $course->setLabel($request->request->get("label"));
            }
            if ($request->request->get("start")) {
                $course->setStart(new \DateTime($request->request->get("start")));
            }
            if ($request->request->get("end")) {
                $course->setEnd(new \DateTime($request->request->get("end")));
            }
            if ($request->request->get("teacher")) {
                $teacherId = $request->request->get("teacher");
                $teacher = $this->teacherRepository->find($teacherId);
                if ($teacher instanceof Teacher) {
                    $course->setTeacher($teacher);
                } else {
                    return $this->returnBad("teacher");
                }
            }
            if ($request->request->get("classroom")) {
                $classroomId = $request->request->get("classroom");
                $classroom = $this->classroomRepository->find($classroomId);
                if ($classroom instanceof Classroom) {
                    $course->setClassroom($classroom);
                } else {
                    return $this->returnBad("classroom");
                }
            }
            if ($request->request->get("promotion")) {
                $promotionId = $request->request->get("promotion");
                $promotion = $this->promotionRepository->find($promotionId);
                if ($promotion instanceof Promotion) {
                    $course->setPromotion($promotion);
                } else {
                    return $this->returnBad("promotion");
                }
            }
            $this->objectManager->persist($course);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Course (id) : ".$id." has been edited !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/course/{id}", name="api_course_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteCourse($id): Response
    {
        $course = $this->courseRepository->find($id);
        if (!$course instanceof Course) {
            return $this->returnBad("course");
        } else {
            $this->objectManager->remove($course);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Course (id) : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/results/", name="api_results", methods={"GET"})
     * @return Response
     */
    public function allResults(): Response
    {
        $results = $this->resultRepository->findAll();
        if (!empty($results)) {
            foreach ($results as $result) {
                $collection[] = array(
                    "id" => $result->getId(),
                    "score" => $result->getScore(),
                    "student" => [
                        "id" => $result->getStudent()->getId(),
                        "firstname" => $result->getStudent()->getFirstname(),
                        "lastname" => $result->getStudent()->getLastname()
                    ],
                    "course" => [
                        "id" => $result->getCourse()->getId(),
                        "label" => $result->getCourse()->getLabel()
                    ]
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("result");
        }
    }

    /**
     * @Route("/result/new", name="api_result_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createResult(Request $request): Response
    {
        $studentR = $request->request->get("student");
        $courseR = $request->request->get("course");
        $student = $this->studentRepository->find($studentR);
        $course = $this->courseRepository->find($courseR);
        $score = (int) $request->request->get("score");
        if ($score > 20) {
            $collection = array(
                "msg" => "Please, the value have to be between 0 and 20 !"
            );
            $this->returnResponse($collection);
        }
        if ($course instanceof Course && $student instanceof Student) {
            $result = new Result();
            $result->setScore($request->request->get("score"));
            $result->setStudent($student);
            $result->setCourse($course);
            $this->objectManager->persist($result);
            $this->objectManager->flush();
            $collection = array(
                // TODO : Show what you create !
                "msg" => "Result Created !"
            );
            return $this->returnResponse($collection);
        } elseif (!$student instanceof Student && $course instanceof Course) {
            return $this->returnBad("student");
        } elseif ($student instanceof Student && !$course instanceof Course) {
            return $this->returnBad("course");
        }
    }

    /**
     * @Route("/result/{id}", name="api_result_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showResult($id): Response
    {
        $result = $this->resultRepository->find($id);
        if (!$result instanceof Result) {
            $this->returnBad("result");
        } else {
            $collection = array(
                "id"    => $result->getId(),
                "score" => $result->getScore(),
                "student" => [
                    "id" => $result->getStudent()->getId(),
                    "firstname" => $result->getStudent()->getFirstname(),
                    "lastname" => $result->getStudent()->getLastname(),
                    "classroom" => [
                        "id" => $result->getStudent()->getClassroom()->getId(),
                        "label" => $result->getStudent()->getClassroom()->getLabel()
                    ]
                ],
                "course" => [
                    "id" => $result->getCourse()->getId(),
                    "label" => $result->getCourse()->getLabel(),
                    "teacher" => [
                        "id" => $result->getCourse()->getTeacher()->getId(),
                        "firstname" => $result->getCourse()->getTeacher()->getFirstname(),
                        "lastname" => $result->getCourse()->getTeacher()->getLastname()
                    ]
                ]
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/result/{id}", name="api_result_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editResult($id, Request $request): Response
    {
        $result = $this->resultRepository->find($id);
        if (!$result instanceof Result) {
            $this->returnBad("result");
        } else {
            if ($request->request->get("score")) {
                $result->setScore($request->request->get("score"));
            }
            if ($request->request->get("student")) {
                $studentId = $request->request->get("student");
                $student = $this->studentRepository->find($studentId);
                if ($student instanceof Student) {
                    $result->setStudent($student);
                } else {
                    return $this->returnBad("student");
                }
            }
            if ($request->request->get("course")) {
                $courseId = $request->request->get("course");
                $course = $this->courseRepository->find($courseId);
                if ($course instanceof Course) {
                    $result->setCourse($course);
                } else {
                    return $this->returnBad("course");
                }
            }
            $this->objectManager->persist($result);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Result (id) : ".$id." has been edited !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/result/{id}", name="api_result_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteResult($id): Response
    {
        $result = $this->resultRepository->find($id);
        if (!$result instanceof Result) {
            return $this->returnBad("result");
        } else {
            $this->objectManager->remove($result);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Result (id) : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/students/", name="api_students", methods={"GET"})
     * @return Response
     */
    public function allStudents(): Response
    {
        $students = $this->studentRepository->findAll();
        if (!empty($students)) {
            foreach ($students as $student) {
                $collection[] = array(
                    "id" => $student->getId(),
                    "firstname" => $student->getFirstname(),
                    "lastname" => $student->getLastname(),
                    "age" => $student->getAge(),
                    "entry_date" => $student->getEntryDate()
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("student");
        }
    }

    /**
     * @Route("/student/new", name="api_student_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createStudent(Request $request): Response
    {
        $promotionR = $request->request->get("promotion");
        $classroomR = $request->request->get("classroom");
        $promotion = $this->promotionRepository->find($promotionR);
        $classroom = $this->classroomRepository->find($classroomR);

        if ($promotion instanceof Promotion && $classroom instanceof Classroom) {
            $student = new Student();
            $student->setFirstname($request->request->get("firstname"));
            $student->setLastname($request->request->get("lastname"));
            $student->setAge($request->request->get("age"));
            $student->setEntryDate(new \DateTime($request->request->get("entry_date")));
            $student->setPromotion($promotion);
            $student->setClassroom($classroom);
            $this->objectManager->persist($student);
            $this->objectManager->flush();
            $collection = array(
                // TODO : Show what you create !
                "msg" => "Student Created !"
            );
            return $this->returnResponse($collection);
        } elseif (!$promotion instanceof Promotion && $classroom instanceof Classroom) {
            return $this->returnBad("promotion");
        } elseif ($promotion instanceof Promotion && !$classroom instanceof Classroom) {
            return $this->returnBad("classroom");
        }
    }

    /**
     * @Route("/student/{id}", name="api_student_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showStudent($id): Response
    {
        $student = $this->studentRepository->find($id);
        if (!$student instanceof Student) {
            $this->returnBad("student");
        } else {
            $arrayResults = array();
            $results = $student->getResults();
            foreach($results as $result) {
                array_push($arrayResults, [
                    "id" => $result->getId(),
                    "score" => $result->getScore(),
                    "course" => [
                        "id" => $result->getCourse()->getId(),
                        "label" => $result->getCourse()->getLabel(),
                        "start" => $result->getCourse()->getStart(),
                        "end" => $result->getCourse()->getEnd()
                    ]
                ]);
            }
            $collection = array(
                "id"    => $student->getId(),
                "firstname" => $student->getFirstname(),
                "lastname" => $student->getLastname(),
                "age" => $student->getAge(),
                "entry_date" => $student->getEntryDate(),
                "promotion" => [
                    "id" => $student->getPromotion()->getId(),
                    "start" => $student->getPromotion()->getStart(),
                    "end" => $student->getPromotion()->getEnd()
                ],
                "classroom" => [
                    "id" => $student->getClassroom()->getId(),
                    "label" => $student->getClassroom()->getLabel()
                ],
                "results" => $arrayResults
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/student/{id}", name="api_student_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editStudent($id, Request $request): Response
    {
        $student = $this->studentRepository->find($id);
        if (!$student instanceof Student) {
            $this->returnBad("student");
        } else {
            if ($request->request->get("firstname")) {
                $student->setFirstname($request->request->get("firstname"));
            }
            if ($request->request->get("lastname")) {
                $student->setLastname($request->request->get("lastname"));
            }
            if ($request->request->get("age")) {
                $student->setAge($request->request->get("age"));
            }
            if ($request->request->get("entry_date")) {
                $student->setEntryDate(new \DateTime($request->request->get("entry_date")));
            }
            if ($request->request->get("promotion")) {
                $promotionId = $request->request->get("promotion");
                $promotion = $this->promotionRepository->find($promotionId);
                if ($promotion instanceof Promotion) {
                    $student->setPromotion($promotion);
                } else {
                    return $this->returnBad("promotion");
                }
            }
            if ($request->request->get("classroom")) {
                $classroomId = $request->request->get("classroom");
                $classroom = $this->classroomRepository->find($classroomId);
                if ($classroom instanceof Classroom) {
                    $student->setClassroom($classroom);
                } else {
                    return $this->returnBad("classroom");
                }
            }
            $this->objectManager->persist($student);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Student (id) : ".$id." has been edited !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/student/{id}", name="api_student_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteStudent($id): Response
    {
        $student = $this->studentRepository->find($id);
        if (!$student instanceof Student) {
            return $this->returnBad("student");
        } else {
            $this->objectManager->remove($student);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Student (id) : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    /**
     * @Route("/teachers/", name="api_teachers", methods={"GET"})
     * @return Response
     */
    public function allTeachers(): Response
    {
        $teachers = $this->teacherRepository->findAll();
        if (!empty($teachers)) {
            foreach ($teachers as $teacher) {
                $collection[] = array(
                    "id" => $teacher->getId(),
                    "firstname" => $teacher->getFirstname(),
                    "lastname" => $teacher->getLastname(),
                    "entry_date" => $teacher->getEntryDate()
                );
            }
            return $this->returnResponse($collection);
        } else {
            return $this->returnBad("teacher");
        }
    }
    /**
     * @Route("/teacher/new", name="api_teacher_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createTeacher(Request $request): Response
    {
        $teacher = new Teacher();
        $teacher->setFirstname($request->request->get("firstname"));
        $teacher->setLastname($request->request->get("lastname"));
        $teacher->setEntryDate(new \DateTime('now'));
        $this->objectManager->persist($teacher);
        $this->objectManager->flush();
        $collection = array(
            "msg" => "Teacher has been created !"
        );
        return $this->returnResponse($collection);
    }
    /**
     * @Route("/teacher/{id}", name="api_teacher_show", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function showTeacher($id): Response
    {
        $teacher = $this->teacherRepository->find($id);
        if (!$teacher instanceof Teacher) {
            $this->returnBad("teacher");
        } else {
            // TODO : Bonus => Afficher les cours du professeur.
            $collection = array(
                "id" => $teacher->getId(),
                "firstname" => $teacher->getFirstname(),
                "lastname" => $teacher->getLastname(),
                "entry_date" => $teacher->getEntryDate()
            );
            return $this->returnResponse($collection);
        }
    }
    /**
     * @Route("/teacher/{id}", name="api_teacher_edit", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editTeacher($id, Request $request): Response
    {
        $teacher = $this->teacherRepository->find($id);
        if (!$teacher instanceof Teacher) {
            $this->returnBad("teacher");
        } else {
            if ($request->request->get("firstname")) {
                $teacher->setFirstname($request->request->get("firstname"));
            }
            if ($request->request->get("lastname")) {
                $teacher->setLastname($request->request->get("lastname"));
            }
            if ($request->request->get("entry_date")) {
                $teacher->setEntryDate(new \DateTime($request->request->get("entry_date")));
            }
            $this->objectManager->persist($teacher);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Teacher (id) : ".$id." has been edited !"
            );
            return $this->returnResponse($collection);
        }
    }
    /**
     * @Route("/teacher/{id}", name="api_teacher_delete", methods={"DELETE"})
     * @param $id
     * @return Response
     */
    public function deleteTeacher($id): Response
    {
        $teacher = $this->teacherRepository->find($id);
        if (!$teacher instanceof Teacher) {
            return $this->returnBad("teacher");
        } else {
            $this->objectManager->remove($teacher);
            $this->objectManager->flush();
            $collection = array(
                "msg" => "Teacher (id) : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }
}
