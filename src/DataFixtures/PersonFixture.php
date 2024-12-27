<?php

namespace App\DataFixtures;

use App\Service\PersonService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonFixture extends Fixture
{
    public function __construct(
        private readonly PersonService $personService,
    ){}

    /*
        Commande 'symfony console doctrine:fixture:load --append'
        pour générer toutes ces données dans la bd
    */
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $this->personService->create($faker->firstNameMale,
                $faker->name,
                $faker->numberBetween($min = 1, $max = 100)
            );
        }
        $manager->flush();
    }
}
