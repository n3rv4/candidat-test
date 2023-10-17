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

use App\Entity\Category;
use App\Service\ArticleManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryController extends AbstractController
{
    #[Route('/category/{slug}', name: 'category_show')]
    public function show(?Category $category, ArticleManagerInterface $articleManager): Response
    {
        if (!$category instanceof Category) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('category/show.html.twig', [
            'category' => $category,
            'articles' => $articleManager->getPaginatedArticles($category),
        ]);
    }
}
