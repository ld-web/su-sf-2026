<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const int NB_ARTICLES = 150;

    private const array CATEGORIES = [
        "Sport",
        "Politique",
        "Santé",
        "Technologie",
        "Économie"
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $categories = [];

        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categories[] = $category;
        }

        for ($i = 0; $i < self::NB_ARTICLES; $i++) {
            $article = new Article();
            $article->setTitle($faker->realText(50))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-2 years', 'now')))
                ->setContent($faker->paragraphs($faker->numberBetween(3, 9), true))
                ->setVisible($faker->boolean(80))
                ->setCategory($faker->randomElement($categories))
            ;
            $manager->persist($article);
        }

        $manager->flush();
    }
}