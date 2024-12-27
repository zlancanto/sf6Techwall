<?php

namespace App\Service;

use App\Entity\Person;

class PersonMapper
{
    public function map(string $firstName,
        string $name,
        int $old,
        ?string $job = null,
        ?Person $person = null): Person
    {
        if ($person === null)
        {
            $person = new Person();
        }

        $person->setFirstName($firstName);
        $person->setName($name);
        $person->setOld($old);
        if ($job !== null)
        {
            $person->setJob($job);
        }
        return $person;
    }
}