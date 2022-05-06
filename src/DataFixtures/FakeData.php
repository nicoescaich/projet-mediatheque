<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Employee;
use App\Entity\Reader;


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
            $bd = new Product();
            $bd->setName($faker->name());
            $bd->setPrice($faker->numberBetween(1,500));
            $bd->setDescription($faker->realText(50));
            $bd->setStatus('on-stock');

        $manager->persist($bd);
        }
        for ($i = 1; $i < 5; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName());
            $user->setLastName($faker->lastName());
            $user->setEmail($faker->email());
            $user->setPassword($this->encoder->hashPassword($user,'toto'));
            $user->setAdministrator($faker->boolean());

    $manager->persist($user);
            if($user->getAdministrator()) {
                $employee = new Employee();
                $employee->setOfficeNum($faker->numberBetween(1,100));
                $employee->setService($faker->word);
                $employee->setUser($user);

    $manager->persist($employee);
            } else {
                $reader = new Reader();
                $reader->setUser($user);

    $manager->persist($reader);
            }
    //         if(!$user->getAdministrator()) {
    //             $loan = new Loan;
    //             $loan->setStartDate(new \Datetime());
    //             $loan->setEndDate(new \Datetime('+3 weeks'));

    // $manager->persist($reader);
    //         }
        }
    $manager->flush();
    }
}