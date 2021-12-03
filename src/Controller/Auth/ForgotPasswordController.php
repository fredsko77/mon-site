<?php
namespace App\Controller\Auth;

use App\Entity\User;
use App\Form\Auth\ForgotPasswordType;
use App\Form\Auth\ResetPasswordType;
use App\Mailing\Auth\AuthMailing;
use App\Repository\UserRepository;
use App\Services\Auth\AuthServicesInterface;
use App\Utils\ServicesTrait;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auth")
 */
class ForgotPasswordController extends AbstractController
{

    use ServicesTrait;

    /**
     * @var AuthServicesInterface $service
     */
    private $service;

    /**
     * @var UserRepository $repository
     */
    private $repository;

    /**
     * @var AuthMailing $mailing
     */
    private $mailing;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    public function __construct(AuthServicesInterface $service, UserRepository $repository, AuthMailing $mailing, EntityManagerInterface $manager)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->mailing = $mailing;
        $this->manager = $manager;
    }

    /**
     * @Route("/forgot-password", name="auth_forgot_password", methods={"GET", "POST"})
     */
    public function forgotPassword(Request $request): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->forgotPassword($form->getData());

            $this->addFlash(
                'info',
                'Un e-mail vient de vous être envoyé !'
            );

            return $this->redirectToRoute('auth_forgot_password');
        }

        return $this->renderForm('auth/forgot-password.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/reset-password/{token}", name="auth_reset_password", methods={"GET", "POST"})
     */
    public function resetPassword(string $token, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $valid = false;
        $form = null;
        $user = $this->repository->findOneBy(['token' => $token]);

        if ($user instanceof User) {
            $form = $this->createForm(ResetPasswordType::class, $user);
            $data = $this->tokenBase64Decode($user->getToken());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                if ($this->now() < new DateTime($data['expired_at']['date']) && $user instanceof User) {
                    $valid = true;

                    $user
                        ->setToken(null)
                        ->setUpdatedAt($this->now())
                        ->setPassword($hasher->hashPassword($user, $user->getPassword()))
                    ;

                    $this->addFlash(
                        'info',
                        'Votre mot de passe a bien été modifié'
                    );

                    $this->manager->flush();

                    $this->mailing->passwordChanged($user);

                    return $this->redirectToRoute('app_signin');
                }

                return $this->redirectToRoute('auth_reset_password', ['token' => $token]);
            }
        }

        return $this->renderForm('auth/reset-password.html.twig', [
            'valid' => $valid,
            'form' => $form,
        ]);
    }

}
