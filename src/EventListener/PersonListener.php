<?php

namespace App\EventListener;

use App\Event\AddPersonEvent;
use App\Event\ListAllPersonEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

readonly class PersonListener
{
    public function __construct(private LoggerInterface $logger){}

    public function onPersonAdd(AddPersonEvent $event): void
    {
        $this->logger->debug("J'écoute l'envent AddPersonEventEt ".
            $event->getPerson()->getName()." vient d'être add avec success"
        );
    }

    public function onPersonListAll(ListAllPersonEvent $event): void
    {
        $this->logger->debug("NombrePersons = ".$event->getNumberPerson());
    }

    #[AsEventListener(event: ListAllPersonEvent::LIST_ALL_PERSON_EVENT, priority: 4)]
    public function onPersonTotal(ListAllPersonEvent $event): void
    {
        $this->logger->debug("TotalPersons = ".$event->getNumberPerson());
    }
}