<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Client::class)->findAll();

        for ($i = 0; $i < 250; $i++) {
            $contact = (new Contact())
                ->setName($faker->firstName())
                ->setEmail($faker->email())
                ->setAddress($faker->address())
                ->setCity($faker->city())
                ->setZipCode($faker->postcode())
                ->setCountry($faker->country())
                ->setPhone($faker->phoneNumber())
                ->setIdClient($faker->randomElement($companies));
            $manager->persist($contact);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class,
        ];
    }
}
