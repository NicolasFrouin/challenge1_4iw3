<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Company::class)->findAll();

        for ($i = 0; $i < 250; $i++) {
            $product = (new Product())
                ->setRef($faker->regexify("[A-Z]{3,8}(_\d{3})?"))
                ->setName($faker->words($faker->numberBetween(1,  5), true))
                ->setDescription($faker->words($faker->numberBetween(0, 10), true))
                ->setTaxRate($faker->randomFloat(2, 0, 40))
                ->setPriceNoTax($faker->randomNumber(4))
                ->setPriceWithTax($faker->randomNumber(4))
                ->setWeight($faker->randomFloat(2, 0, 10))
                ->setHeight($faker->randomFloat(2, 0, 10))
                ->setWidth($faker->randomFloat(2, 0, 10))
                ->setDepth($faker->randomFloat(2, 0, 10))
                ->setStock($faker->numberBetween(0, 1_000))
                ->setActive($faker->boolean())
                ->setIdCompany($faker->randomElement($companies));
            $manager->persist($product);
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
