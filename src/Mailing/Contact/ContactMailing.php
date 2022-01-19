<?php
namespace App\Mailing\Contact;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContactMailing
{

    /**
     * @var MailerInterface $mailer
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function contact(Contact $contact)
    {
        $email = (new TemplatedEmail)
            ->from('contact@agathefrederick.fr')
            ->to($contact->getEmail())
            ->bcc('agathefrederick@gmail.com')
            ->subject('Recap de votre demande de contact')
            ->htmlTemplate('emails/contact/recap.html.twig')
            ->context(compact('contact'))
        ;

        return $this->mailer->send($email);
    }

}
