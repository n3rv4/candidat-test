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

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Menu>
 *
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    /**
     * @return Menu[]
     */
    public function getAllVisibleMenus(): array
    {
        $results = $this->createQueryBuilder('m')
            ->where('m.isVisible = true')
            ->orderBy('m.menuOrder')
            ->getQuery()
            ->getResult()
        ;

        if (\is_array($results)) {
            return $results;
        }

        return [];
    }

    public function getIndexQueryBuilder(string $field): QueryBuilder
    {
        return $this->createQueryBuilder('m')
            ->where('m.'.$field.' IS NOT NULL OR (m.page IS NULL AND m.article IS NULL AND m.link IS NULL AND m.category IS NULL)')
        ;
    }
}
