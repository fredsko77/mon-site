<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth")
 */
class ForgotPasswordController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("/forgot-password", name="auth_forgot_password", methods={"GET"})
     */
    public function forgotPassword(): Response
    {
        return $this->render('auth/forgot-password.html.twig');
    }

    /**
     * @Route("/forgot-password", name="auth_forgot_password", methods={"GET"})
     */
    public function sendToken(): Response
    {
        return $this->render('auth/forgot-password.html.twig');
    }

    /**
     * @Route("/reset-password", name="auth_register", methods={"POST"})
     */
    public function resetPassword(): Response
    {
        return $this->render('auth/forgot-password.html.twig');
    }

}
