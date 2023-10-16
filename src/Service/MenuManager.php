<?php

namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepository;

class MenuManager
{
    public function __construct(
        private readonly MenuRepository $menuRepository
    ) {}

    /**
     * @return Menu[]
     */
    public function findAll(): array
    {
        return $this->menuRepository->getAllVisibleMenus();
    }
}
