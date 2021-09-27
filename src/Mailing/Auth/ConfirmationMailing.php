<?php
namespace App\Mailing\Auth;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ConfirmationMailing
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

}
