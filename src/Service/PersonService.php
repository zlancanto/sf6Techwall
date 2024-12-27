<?php

namespace App\Service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

readonly class PersonService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PersonMapper $personMapper
    ){}

    public function create(string $firstName,
        string $name,
        int $old,
        ?string $job = null): Person
    {
        $person = $this->personMapper->map($firstName, $name, $old, $job);
        $this->entityManager->persist($person);
        $this->entityManager->flush();
        return $person;
    }

    public function createOrUpdateWithPerson(Person $person): Person
    {
        $this->entityManager->persist($person);
        $this->entityManager->flush();
        return $person;
    }

    public function delete(?Person $person): ?Person
    {
        if ($person)
        {
            $this->entityManager->remove($person);
            $this->entityManager->flush();
        }
        return $person;
    }

    public function update(
        string $firstName,
        string $name,
        int $old,
        ?Person $person,
        ?string $job = null
    ): ?Person
    {
        if ($person)
        {
            $person = $this->personMapper->map(
                $firstName,
                $name,
                $old,
                $job,
                $person
            );
            $this->entityManager->persist($person);
            $this->entityManager->flush();
        }
        return $person;
    }
}