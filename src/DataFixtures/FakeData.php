<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FakeData extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 10; $i++) {
            $product = new Product();
            $product->setName($faker->name());
            $product->setPrice($faker->numberBetween(1,500));
            $product->setDescription($faker->realText(50));
            $product->setStatus('on-stock');
            $manager->persist($product);
        }

        for ($i = 1; $i < 5; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->encoder->hashPassword($user,'toto'));
            $user->setAdministrator($faker->boolean());
            
            $manager->persist($user);
        }
    $manager->flush();
    }
}