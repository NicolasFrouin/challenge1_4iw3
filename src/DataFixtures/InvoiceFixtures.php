<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Company::class)->findAll();

        for ($i = 0; $i < 250; $i++) {
            $invoiceCompany = $faker->randomElement($companies);
            $invoiceClient = $faker->randomElement($manager->getRepository(Client::class)->findBy(['idCompany' => $invoiceCompany->getId()]));
            $invoice = (new Invoice())
                ->setPaid($faker->boolean())
                ->setPaidAmount($faker->randomNumber(3))
                ->setClient($invoiceClient)
                ->setContact($faker->randomElement($invoiceClient->getContacts()))
                ->setCompany($faker->randomElement($companies))
                ->setStatus($faker->numberBetween(0, 1));

            $products = $manager->getRepository(Product::class)->findBy(['idCompany' => $invoiceCompany->getId()]);
            $numberOfLines = $faker->numberBetween(0, 10);
            for ($j = 0; $j < $numberOfLines; $j++) {
                $invoiceLine = (new InvoiceLine())
                    ->setInvoice($invoice)
                    ->setDescription($faker->words($faker->numberBetween(1, 5), true))
                    ->setQuantity($faker->numberBetween(1, 20))
                    ->setProduct($faker->randomElement($products));
                $manager->persist($invoiceLine);
            }
            $manager->persist($invoice);
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
