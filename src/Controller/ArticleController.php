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
use Symfony\Component\Routing\Annotation\Route;

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
    public function show(?Article $article): Response
    {
        if (!$article instanceof Article) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}
