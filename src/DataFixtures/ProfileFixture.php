<?php

namespace App\DataFixtures;

use App\Entity\Job;
use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $profiles = [
            'whatsApp',
            'linkedIn',
            'snapchat',
            'instagram',
            'facebook',
            'X',
            'telegram',
            'github'
        ];
        for($i = 0; $i < count($profiles); $i++)
        {
            $profile = (new Profile())->setSocialNetwork($profiles[$i]);
            $profile->setUrl("https://www.$profiles[$i].com/");
            $manager->persist($profile);
        }
        $manager->flush();
    }
}
