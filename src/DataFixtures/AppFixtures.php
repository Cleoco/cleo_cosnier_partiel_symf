<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       // liste pour mon sélecteur de catégories
       $categories = ['Rap','Pop','Rock','Blues','Electro','Reggae','Disco','Blues','Jazz','Metal','Punk','Country','Soul','Classique','RnB'];
       // tableau pour enregistrer chaque objet de type Category
       $tabObjetsCategory = []; 
       // Boucle pour créer autant d'objets que de catégories dans la liste
       foreach($categories as $cat){
           $category = new Category();
           $category->setTitle($cat);
           $manager->persist($category);
           array_push($tabObjetsCategory,$category);
       }

        $manager->flush();
    }
}
