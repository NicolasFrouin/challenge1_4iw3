<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Security;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $currentUser = $this->container->get(Security::class)->getUser();

        for ($i = 0; $i < 25; $i++) {
            $customer = (new Customer())
                ->setId($faker->randomNumber(10))
                ->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setCreatedAt($faker->dateTimeBetween('-5 days', 'now'))
                ->setModifiedAt($faker->dateTimeBetween('-5 days', 'now'))
                // Créer par l'administrateur qui est connecté
                ->setCreatedBy($currentUser->getId())
                // Modifier par l'administrateur qui est connecté
                ->setModifiedBy($currentUser->getId())
                ->setIdCompany($faker->randomNumber(10));

            $manager->persist($customer);
        }

        $manager->flush();
    }
}