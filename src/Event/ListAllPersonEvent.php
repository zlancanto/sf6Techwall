<?php

namespace App\Event;

use App\Entity\Person;
use Symfony\Contracts\EventDispatcher\Event;

class ListAllPersonEvent extends Event
{
    const LIST_ALL_PERSON_EVENT = 'person.list_all';

    public function __construct(private readonly int $numberPerson){}

    public function getNumberPerson(): int
    {
        return $this->numberPerson;
    }
}