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
                            'id' => $classroom->getId(),
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
                break;
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
                break;
            case "course":
                $msg = "Wrong Course !";
                break;
            case "result":
                $msg = "Wrong Result !";
                break;
            case "student":
                $msg = "Wrong Student !";
                break;
            case "teacher":
                $msg = "Wrong Teacher !";
                break;
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
        $collection = array();
        // TODO : (Bonus) => Count how many Student are in !
        foreach ($classrooms as $classroom) {
            $collection[] = array(
                'id'    => $classroom->getId(),
                'label' => $classroom->getLabel(),
                'promotion' => [
                    'id'    => $classroom->getPromotion()->getId(),
                    'start' => $classroom->getPromotion()->getStart(),
                    'end'   => $classroom->getPromotion()->getEnd()
                ]
            );
        }
        return $this->returnResponse($collection);
    }

    /**
     * @Route("/classroom/new", name="api_classroom_new", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function createClassroom(Request $request) : Response
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
            $collection[] = array(
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
            $collection[] = array(
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
            return $this->returnResponse($classroom);
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
            $collection[] = array(
                "msg" => "Classroom : ".$id." has been deleted !"
            );
            return $this->returnResponse($collection);
        }
    }

    // TODO : Course (All, Create, Show, Edit, Delete)

    // TODO : Promotion (All, Create, Show, Edit, Delete)

    // TODO : Result (All, Create, Show, Edit, Delete)

    // TODO : Student (All, Create, Show, Edit, Delete)

    // TODO : Teacher (All, Create, Show, Edit, Delete)
}
