<?php
namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 25; $i++) {
            $client = (new Client())
                ->setIdCompany($faker->randomNumber(10))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setCreatedAt($faker->dateTimeBetween('-5 days', 'now'))
                ->setModifiedAt($faker->dateTimeBetween('-5 days', 'now'))
                ->setCreatedBy($faker->dateTimeBetween('-5 days', 'now'))
                ->setModifiedBy($faker->dateTimeBetween('-5 days', 'now'));

            $manager->persist($client);
        }

        $manager->flush();
    }
}