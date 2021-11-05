<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Comment;
use App\Entity\Post;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($p = 0; $p < 50; $p++) {
            $post = new Post;
            $post->setTitle($faker->catchPhrase)
                ->setContent( $faker->realText($maxNbChars = 700) )
                ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            $manager->persist($post);

            for ($c = 0; $c < mt_rand(3, 5); $c++) {
                $comment = new Comment;
                $comment->setContent( $faker->realText($maxNbChars = 177) )
                    ->setUsername($faker->userName)
                    ->setPost($post);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
