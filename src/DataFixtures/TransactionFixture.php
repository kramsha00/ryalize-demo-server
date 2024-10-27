<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TransactionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $locations = null;
        $users = null;

        echo "Loading users...\n";
        // Fetch existing users from the database
        $users = $manager->getRepository(User::class)->findAll(); // Get all users
        echo "Loaded users: " . count($users) . "\n";

        echo "Loading locations...\n";
        // Fetch existing locations from the database
        $locations = $manager->getRepository(Location::class)->findAll();
        echo "Loaded locations: " . count($locations) . "\n";

        for ($i = 0; $i < 100000; $i++) {
            $transaction = new Transaction();
            $transaction->setAmount($faker->randomFloat(2, 10, 1000));
            $transaction->setDate($faker->dateTimeThisYear);
            $transaction->setUser($users[array_rand($users)]);
            $transaction->setLocation($locations[array_rand($locations)]);
            $manager->persist($transaction);

            // Flush in batches to avoid memory overload
            if ($i % 500 === 0) {
                $manager->flush();
                $manager->clear(Transaction::class);  // Clear memory after each batch
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AppFixtures::class,
            LocationFixture::class
        ];
    }

}
