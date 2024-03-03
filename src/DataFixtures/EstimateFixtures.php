<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Estimate;
use App\Entity\EstimateLine;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EstimateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Company::class)->findAll();

        for ($i = 0; $i < 250; $i++) {
            $estimateCompany = $faker->randomElement($companies);
            $estimateClient = $faker->randomElement($manager->getRepository(Client::class)->findBy(['idCompany' => $estimateCompany->getId()]));
            $estimate = (new Estimate())
                ->setSigned($faker->boolean())
                ->setClient($estimateClient)
                ->setContact($faker->randomElement($estimateClient->getContacts()))
                ->setCompany($faker->randomElement($companies))
                ->setStatus($faker->numberBetween(0, 1));

            $products = $manager->getRepository(Product::class)->findBy(['idCompany' => $estimateCompany->getId()]);
            $numberOfLines = $faker->numberBetween(0, 10);
            for ($j = 0; $j < $numberOfLines; $j++) {
                $estimateLine = (new EstimateLine())
                    ->setEstimate($estimate)
                    ->setDescription($faker->words($faker->numberBetween(1, 5), true))
                    ->setQuantity($faker->numberBetween(1, 20))
                    ->setProduct($faker->randomElement($products));
                $manager->persist($estimateLine);
            }
            $manager->persist($estimate);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            ClientFixtures::class,
            ProductFixtures::class,
        ];
    }
}
