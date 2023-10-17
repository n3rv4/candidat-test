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

namespace App\Service;

use App\Entity\Article;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class CategoryManager implements CategoryManagerInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private CategoryRepository $categoryRepository,
        private PaginatorInterface $paginator
    ) {}

    public function getPaginatedCategories(?Article $article = null, int $limit = 5): PaginationInterface
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request instanceof Request) {
            throw new \RuntimeException('Request not found');
        }

        return $this->paginator->paginate(
            $this->categoryRepository->findPerPagination($article),
            $request->query->getInt('page', 1),
            $limit
        );
    }
}
