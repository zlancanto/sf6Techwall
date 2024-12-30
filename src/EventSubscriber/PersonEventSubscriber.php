<?php

namespace App\EventSubscriber;

use App\Event\AddPersonEvent;
use App\Service\MailerService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

readonly class PersonEventSubscriber implements EventSubscriberInterface
{

    public function __construct(private MailerService $mailerService){}

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AddPersonEvent::ADD_PERSON_EVENT => [
                ['onPersonAdd', 3000]
            ],
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onPersonAdd(AddPersonEvent $event): void
    {
        $person = $event->getPerson();
        $mailMessage = $person->getFirstname().' '
            .$person->getName().' created successfully'
        ;
        $this->mailerService->sendEmail(to: 'mihanzlancanto@gmail.com',
            subject: $mailMessage
        );
    }
}