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

use App\Service\ArticleManagerInterface;
use App\Service\CategoryManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ArticleManagerInterface $articleManager,
        CategoryManagerInterface $categoryManager
    ): Response {
        return $this->render('home/index.html.twig', [
            'articles' => $articleManager->getPaginatedArticles(),
            'categories' => $categoryManager->getPaginatedCategories(),
        ]);
    }
}
