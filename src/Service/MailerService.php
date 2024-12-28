<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MailerService
{
    public function __construct(private MailerInterface $mailer,
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
            ->from($this->getFromMailer())
            ->to($to)
            ->priority($priority)
            ->subject($subject)
            ->text($text)
            ->html($html);

        $this->mailer->send($email);

        // ...
    }

    public function getFromMailer(): string
    {
        return $this->fromMailer;
    }
}