<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct(private MailerInterface $mailer,
        private string $replyTo,
        private string $fromMailer,
    ){}

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmail(string $to,
        string $subject,
        string $priority = Email::PRIORITY_HIGH,
        string $html = '<p>See Twig integration for better HTML integration!</p>',
        ?string $text = null,
    ): void
    {
        $email = (new Email())
            ->from($this->fromMailer)
            ->to($to)
            ->replyTo($this->replyTo)
            ->priority($priority)
            ->subject($subject)
            ->text($text)
            ->html($html);

        $this->mailer->send($email);

        // ...
    }

    public function getUser(): User
    {
        return $this->getUser();
    }
}