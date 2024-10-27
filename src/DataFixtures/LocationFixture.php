<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LocationFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Generate 5 fake locations
        for ($i = 0; $i < 5; $i++) {
            $location = new Location();
            $location->setAddress($faker->company . ' ' . $faker->streetAddress);
            $location->setCity($faker->city);
            $location->setCountry($faker->country);
            $manager->persist($location);
        }

        // Flush all persisted data to the database
        $manager->flush();
    }
}
