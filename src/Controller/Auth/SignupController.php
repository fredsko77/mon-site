<?php
namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Services\Auth\SignupServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth/signup", name="auth_signup")
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
     * @Route("", name="", methods={"GET", "POST"})
     */
    public function signup(Request $request): Response
    {
        if ($this->getUser()) {

            return $this->redirectToRoute('admin');
        }

        $user = new User;
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($user);

            $this->addFlash(
                'success',
                'Votre compte a bien été crée'
            );

            return $this->redirectToRoute('auth_signup');
        }

        return $this->renderForm('auth/signup.html.twig', [
            'form' => $form,
        ]);
    }

}
