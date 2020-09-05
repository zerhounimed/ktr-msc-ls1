<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Card;

class CardFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 1; $i<= 10; $i++){
            $card = new Card();
            $card-> setName("Name n° $i")
                ->setCompanyName("NameCompany n° $i")
                ->setEmail("email@hotmail.com")
                -> setTelephone(030303032);
            $manager->persist($card);

            $manager->flush();


        }

        $manager->flush();
    }
}
