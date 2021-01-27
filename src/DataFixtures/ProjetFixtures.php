<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Projet;
class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 1; $i <= 10; $i++){
            $projet = new Projet();
            $projet->setTitle("Projet n°$i");
            $projet->setDescription("<p>Description du Projet n°$i</p>");
            $projet->setImage("https://picsum.photos/300/300");
            $projet->setGithub("Lien github du projet n°$i");
            $projet->setWeblink("Weblink du projet n°$i");
            
            $manager->persist($projet);
            }
        $manager->flush();
    }
}
