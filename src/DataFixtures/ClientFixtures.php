<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Supposons que vous voulez utiliser le premier utilisateur de la base de données
        $user = $this->userRepository->findOneBy([]);

        for ($i = 0; $i < 25; $i++) {
            $client = new Client();
            $client->setFirstname($faker->firstName())
                   ->setLastname($faker->lastName())
                   ->setCreatedAt($faker->dateTimeBetween('-5 days', 'now'))
                   ->setModifiedAt($faker->dateTimeBetween('-5 days', 'now'))
                   ->setCreatedBy($user)
                   ->setModifiedBy($user)
                   ->setIdCompany($faker->randomNumber());

            $manager->persist($client);
        }

        $manager->flush();
    }
}