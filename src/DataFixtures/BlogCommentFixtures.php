<?php

namespace App\DataFixtures;

use App\Entity\BlogPostComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BlogCommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < BlogPostFixtures::POST_COUNT; $i++)
        {
            for($y = 0; $y < random_int(0, 10); $y++)
            {
                $comment = new BlogPostComment();
                $comment->setContent('lorem ipsum dolor amet')
                    ->setBlogPost($this->getReference('post'.$i))
                    ->setAuthorIp(random_int(1, 2) === 2 ? '127.0.0.1' : '127.0.0.2');
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BlogPostFixtures::class
        ];
    }
}
