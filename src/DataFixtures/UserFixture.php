<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin1 = (new User())->setUsername('zlancanto1')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $admin1->setPassword($this->hasher->hashPassword($admin1, 'admin1'));
        $admin2 = (new User())->setUsername('zlancanto2')
            ->setRoles(['ROLE_ADMIN'])
        ;
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'admin2'));

        for ($i = 0; $i < 5; $i++)
        {
            $user = (new User())->setUsername('user'.$i);
            $user->setPassword($this->hasher->hashPassword($user, 'user'));
            $manager->persist($user);
        }
        $manager->persist($admin1);
        $manager->persist($admin2);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['user'];
    }
}
