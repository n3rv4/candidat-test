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

use App\Entity\Menu;
use App\Repository\MenuRepository;

final readonly class MenuManager implements MenuManagerInterface
{
    public function __construct(
        private MenuRepository $menuRepository
    ) {}

    /**
     * @return Menu[]
     */
    public function findAll(): array
    {
        return $this->menuRepository->getAllVisibleMenus();
    }
}
