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
        private readonly UserPasswordHasherInterface $hasher,
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin1 = (new User())->setUsername('admin1')
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin1@test.com')
        ;
        $admin1->setPassword($this->hasher->hashPassword($admin1, 'admin'));
        $admin2 = (new User())->setUsername('admin2')
            ->setRoles(['ROLE_ADMIN'])
            ->setEmail('admin2@test.com')
        ;
        $admin2->setPassword($this->hasher->hashPassword($admin2, 'admin'));

        for ($i = 0; $i < 5; $i++)
        {
            $user = (new User())->setUsername('user'.$i)
                ->setEmail('user'.$i.'@test.com')
            ;
            $user->setPassword($this->hasher->hashPassword($user, 'user'));
            $manager->persist($user);
        }
        $manager->persist($admin1);
        $manager->persist($admin2);
        $manager->flush();
    }

    /*
     * Pour l'exécution unique du fixture
     * php bin/console doctrine:fixtures:load --group=group1 --group=group2
     * */
    public static function getGroups(): array
    {
        return ['user'];
    }
}
