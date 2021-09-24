<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth")
 */
class RegisterController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("/register", name="auth_register", methods={"GET"})
     */
    public function register(): Response
    {
        return $this->render('auth/register.html.twig');
    }

    /**
     * @Route("/store", name="auth_store", methods={"POST"})
     */
    public function store(): Response
    {
        return $this->render('auth/forgot-password.html.twig');
    }

}
