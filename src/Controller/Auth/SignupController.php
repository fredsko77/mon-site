<?php
namespace App\Controller\Auth;

use App\Services\Auth\SignupServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/signup")
 */
class SignupController extends AbstractController
{

    /**
     * @var SignupServicesInterface $service
     */
    private $service;

    public function __construct(SignupServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("", name="auth_signup", methods={"GET"})
     */
    public function signup(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('auth/signup.html.twig');
    }

    /**
     * @Route("", name="auth_signup_store", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->service->store($request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'user:read']
        );
    }

}
