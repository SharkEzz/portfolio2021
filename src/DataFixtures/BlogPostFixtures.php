<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\AsciiSlugger;

class BlogPostFixtures extends Fixture implements DependentFixtureInterface
{
    public const POST_COUNT = 15;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $slugger = new AsciiSlugger();

        for($i = 0; $i < self::POST_COUNT; $i++)
        {
            $title = $faker->text(15);
            $slug = $slugger->slug($title);

            $post = new BlogPost();
            $post->setTitle($title)
                ->setSlug($slug)
                ->setContent($faker->text())
                ->setCategory($this->getReference('cat'.random_int(1, 3)));
            $this->setReference('post'.$i, $post);

            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BlogCategoriesFixtures::class
        ];
    }
}
