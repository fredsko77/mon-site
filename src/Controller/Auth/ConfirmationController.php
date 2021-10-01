<?php

namespace App\Controller\Auth;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/confirmation")
 */
class ConfirmationController extends AbstractController
{

    use ServicesTrait;

    /**
     * @var UserRepository $repository
     */
    private $repository;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    public function __construct(UserRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @Route("/{token}", name="auth_confirmation")
     */
    public function index(User $user): Response
    {
        $data = $this->tokenBase64Decode($user->getToken());
        $valid = false;

        if ($this->now() < new DateTime($data['expired_at']['date']) && $user instanceof User) {
            $valid = true;

            $user
                ->setToken(null)
            ;

            $this->manager->persist($user);
            $this->manager->flush();
        }

        return $this->render('auth/confirm.html.twig', compact('user'));
    }
}
