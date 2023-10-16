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

namespace App\Twig;

use App\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

final class AppExtension extends AbstractExtension
{
    public function __construct(private readonly RouterInterface $router) {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('categoriesToString', [$this, 'categoriesToString']),
        ];
    }

    public function categoriesToString(Collection $categories): string
    {
        $generateCategoryLink = function (Category $category) {
            $url = $this->router->generate('category_show', [
                'slug' => $category->getSlug(),
            ]);

            return '<a href="'.$url.'" style="color: "'.$category->getColor().'>'.$category->getName().'</a>';
        };

        /** @phpstan-ignore-next-line */
        $categoryLinks = array_map($generateCategoryLink, $categories->toArray());

        return implode(', ', $categoryLinks);
    }
}
