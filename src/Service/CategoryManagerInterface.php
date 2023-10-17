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
use Knp\Component\Pager\Pagination\PaginationInterface;

interface CategoryManagerInterface
{
    public function getPaginatedCategories(?Article $article = null): PaginationInterface;
}
