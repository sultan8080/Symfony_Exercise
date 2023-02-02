<?php

namespace App\Service;

use SebastianBergmann\Template\Template;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/*
 Service qui permet de generer un mail
*/

class MailerService
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }
    public function send(
        string $to,
        string $subject,
        string $templateTwig,
        array $context
    ): void {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@mysite.com', 'Mon Site'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("mails/$templateTwig")
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $transportException) {
            throw $transportException;
        }
    }
}
