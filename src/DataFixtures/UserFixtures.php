<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $companies = $manager->getRepository(Company::class)->findAll();

        $pass = "pass";

        $user = (new User())
            ->setEmail("admin@app.com")
            ->setRoles([User::ROLE_ADMIN])
            ->setIsVerified(true);
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('admin', $user);

        $user = (new User())
            ->setEmail("company@app.com")
            ->setRoles([User::ROLE_COMPANY])
            ->setIsVerified(true)
            ->setIdCompany($faker->randomElement($companies));
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('company', $user);

        $user = (new User())
            ->setEmail("accountant@app.com")
            ->setRoles([User::ROLE_ACCOUNTANT])
            ->setIsVerified(true)
            ->setIdCompany($faker->randomElement($companies));
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('accountant', $user);

        $user = (new User())
            ->setEmail("user@app.com")
            ->setRoles([User::ROLE_USER])
            ->setIsVerified(true)
            ->setIdCompany($faker->randomElement($companies));
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('user', $user);

        for ($i = 0; $i < 15; $i++) {
            $user = (new User())
                ->setEmail($faker->email)
                ->setPassword($this->passwordHasher->hashPassword($user, $pass))
                ->setIsVerified($faker->boolean())
                ->setIdCompany($faker->randomElement($companies));
            $manager->persist($user);
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
