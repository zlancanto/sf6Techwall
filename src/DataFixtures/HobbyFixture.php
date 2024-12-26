<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hobbies = [
            'Voyage',
            'Basket',
            'Football',
            'Rugby',
            'Lecture',
            'Yoga',
            'Méditation',
            'Etude de math',
            'Sommeil',
            'Danse',
            'Chant',
            'Karaoké',
            'Atlétisme'
        ];
        for($i = 0; $i < count($hobbies); $i++)
        {
            $hobby = (new Hobby())->setDesignation($hobbies[$i]);
            $manager->persist($hobby);
        }
        $manager->flush();
    }
}
