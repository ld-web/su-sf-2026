<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const int NB_ARTICLES = 50;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();

            $article
                ->setTitle($faker->realText(50))
                ->setContent($faker->paragraphs(
                    $faker->numberBetween(3, 9),
                    true
                ))
                ->setVisible($faker->boolean(80))
                ->setCreatedAt(
                    DateTimeImmutable::createFromMutable(
                        $faker->dateTimeBetween('-2 years')
                    )
                )
            ;

            $manager->persist($article);
        }

        $manager->flush();
    }
}