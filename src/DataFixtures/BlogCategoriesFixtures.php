<?php

namespace App\DataFixtures;

use App\Entity\BlogCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogCategoriesFixtures extends Fixture
{
    public const CAT_1 = 'cat1';
    public const CAT_2 = 'cat2';
    public const CAT_3 = 'cat3';

    public function load(ObjectManager $manager)
    {
        $cat1 = new BlogCategory();
        $cat1->setName('Dev');
        $manager->persist($cat1);
        $this->setReference(self::CAT_1, $cat1);

        $cat2 = new BlogCategory();
        $cat2->setName('Perso');
        $manager->persist($cat2);
        $this->setReference(self::CAT_2, $cat2);

        $cat3 = new BlogCategory();
        $cat3->setName('Autre');
        $manager->persist($cat3);
        $this->setReference(self::CAT_3, $cat3);

        $manager->flush();
    }
}
