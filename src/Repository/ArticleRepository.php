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

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findPerPagination(?Category $category = null): Query
    {
        $queryBuilder = $this->createQueryBuilder('article')
            ->orderBy('article.createdAt', 'DESC')
        ;

        if ($category !== null) {
            $queryBuilder
                ->leftJoin('article.categories', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $category->getId(), 'uuid')
            ;
        }

        return $queryBuilder->getQuery();
    }
}
