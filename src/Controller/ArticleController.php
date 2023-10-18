<?php

declare(strict_types=1);

/*
 * This file is part of the BT project.
 *
 * Copyright (c) 2023 BT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Article;
use App\Service\ArticleManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comments;
use App\Entity\User;
use App\Form\CommentFormType;

final class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'article_index')]
    public function index(
        ArticleManagerInterface $articleManager
    ): Response {
        return $this->render('article/index.html.twig', [
            'articles' => $articleManager->getPaginatedArticles(),
        ]);
    }

    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$article instanceof Article) {
            return $this->redirectToRoute('app_home');
        }

        $comments = $entityManager->getRepository(Comments::class)->findBy(['article' => $article]);
        $user = $this->getUser();
        $comment = new Comments();
        $commentForm = $this->createForm(CommentFormType::class,$comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setArticle($article);
            $comment->setAppUser($user);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('article_show',['slug'=> $article->getSlug()]);
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm,
            'comments' => $comments,
        ]);
    }
}
