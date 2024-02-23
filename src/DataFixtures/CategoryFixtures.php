<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(('fr_FR'));

        for($i=0;$i< 10; $i++){
            $category = new Category();
            $category->setName($faker->sentence($nbWords = 1, $variableNbWords = true))
                ->setDescription(mt_rand(0,1)===1 ? $faker->realText(254): null);

            $manager->persist($category);    
        }

        $manager->flush();
    }


}