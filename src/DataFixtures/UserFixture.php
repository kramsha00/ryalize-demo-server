<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $faker = Factory::create();
//
//        for ($i = 0; $i < 20; $i++) {
//            $user = new User();
//            $user->setFirstName($faker->firstName);
//            $user->setLastName($faker->lastName);
//            $user->setEmail($faker->unique()->email);
//            $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
//
//            // Persist the user entity to the database
//            $manager->persist($user);
//        }
//
//        // Flush all persisted data to the database
//        $manager->flush();
    }
}
