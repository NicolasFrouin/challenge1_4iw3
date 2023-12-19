<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 25; $i++) {
            $company = (new Company())
                ->setName($faker->company)
                ->setDescription($faker->words($faker->numberBetween(0, 10), true))
                ->setSiret($faker->regexify('\d{14}'))
                ->setPremium($faker->boolean())
                ->setCreatedBy($faker->randomElement($users))
                ->setModifiedBy($faker->randomElement($users));
            $manager->persist($company);
        }

        $manager->flush();
    }
}
