<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $pass = "pass";

        $user = (new User())
            ->setEmail("admin@app.com")
            ->setRoles([User::ROLE_ADMIN]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('admin', $user);

        $user = (new User())
            ->setEmail("company@app.com")
            ->setRoles([User::ROLE_COMPANY]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('company', $user);

        $user = (new User())
            ->setEmail("accountant@app.com")
            ->setRoles([User::ROLE_ACCOUNTANT]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
        $manager->persist($user);
        $this->addReference('accountant', $user);

        for ($i = 0; $i < 10; $i++) {
            $user = (new User())->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashPassword($user, $pass));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
