<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    }
    /**
     * @Route("/test", name="test")
     */
    public function test() : Response
    {
        return $this->json([
            'message' => 'You are authorize to use this API !',
            'firstname' => $this->user->getFirstname(),
            'lastname' => $this->user->getLastname(),
            'email' => $this->user->getEmail(),
            'Token' => $this->user->getApiToken()
        ]);
    }
}
