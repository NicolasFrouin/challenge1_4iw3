<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Company::class)->findAll();

        for ($i = 0; $i < 250; $i++) {
            $client = (new Client())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setAddress($faker->address())
                ->setPhone($faker->phoneNumber())
                ->setIdCompany($faker->randomElement($companies));
            $manager->persist($client);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
