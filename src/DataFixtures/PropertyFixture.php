<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) 
        {
            $property = new Property();
            $property
                ->setTitle($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setSurface($faker->numberBetween(20,300))
                ->setRooms($faker->numberBetween(2,10))
                ->setBedrooms($faker->numberBetween(1,4))
                ->setPrice($faker->numberBetween(100000,1500000))
                ->setGarden($faker->numberBetween(0,1))
                ->setParking($faker->numberBetween(0,1))
                ->setPool($faker->numberBetween(0,2))
                ->setCity($faker->city)
                ->setadresse($faker->address)
                ->setpostalCode($faker->postcode)
                ->setCity($faker->city)
                ->setSold(false);

                










        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
