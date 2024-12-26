<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\en_US\Company;
use Faker\Provider\fr_FR\Person;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobs = [
            'Data scientist',
            'Statisticien',
            'Data analyste',
            'Data Engeneer',
            'Analyste cyber-sécurité',
            'Développeur',
            'DevOps',
            'Testeur',
            'Ingénieur logiciel',
            'Mathématicien',
            'Médecin'
        ];
        for($i = 0; $i < count($jobs); $i++)
        {
            $job = (new Job())->setDesignation($jobs[$i]);
            $manager->persist($job);
        }
        $manager->flush();
    }
}
