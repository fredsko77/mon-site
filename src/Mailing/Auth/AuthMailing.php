<?php
namespace App\Mailing\Auth;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class AuthMailing
{

    /**
     * @var MailerInterface $mailer
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function confirmEmail(User $user)
    {
        $email = (new TemplatedEmail)
            ->from('contact@agathefrederick.fr')
            ->to($user->getEmail())
            ->subject('Confirmation de votre compte')
            ->htmlTemplate('emails/auth/confirm.html.twig')
            ->context(compact('user'))
        ;

        return $this->mailer->send($email);
    }

    public function forgotPassword(User $user)
    {
        $email = (new TemplatedEmail)
            ->from('contact@agathefrederick.fr')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->htmlTemplate('emails/auth/forgot-password.html.twig')
            ->context(compact('user'))
        ;

        return $this->mailer->send($email);
    }

    public function passwordChanged(User $user)
    {
        $email = (new TemplatedEmail)
            ->from('contact@agathefrederick.fr')
            ->to($user->getEmail())
            ->subject('Modification mot de passe')
            ->htmlTemplate('emails/auth/password-changed.html.twig')
            ->context(compact('user'))
        ;

        return $this->mailer->send($email);
    }

}
