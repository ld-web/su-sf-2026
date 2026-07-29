<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/articles/add', name: 'article_add')]
    public function add(
        Request $request,
        EntityManagerInterface $em,
        SluggerInterface $slugger
    ): Response {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article
                ->setCreatedAt(new DateTimeImmutable())
                ->setSlug($slugger->slug($article->getTitle()));
            $em->persist($article);
            $em->flush();
        }

        return $this->render('article/add.html.twig', [
            'articleForm' => $form
        ]);
    }
}