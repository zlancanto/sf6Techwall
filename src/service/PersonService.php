<?php

namespace App\service;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

class PersonService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PersonMapper $personMapper
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
}