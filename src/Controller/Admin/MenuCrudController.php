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

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

final class MenuCrudController extends AbstractCrudController
{
    public const MENU_PAGES = 0;
    public const MENU_ARTICLES = 1;
    public const MENU_LINKS = 2;
    public const MENU_CATEGORIES = 3;

    public function __construct(
        private readonly MenuRepository $menuRepository,
        private readonly RequestStack $requestStack
    ) {}

    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        $subMenuIndex = $this->getSubMenuIndex();

        $entityLabelInSingular = 'menu';

        $entityLabelInPlural = match ($subMenuIndex) {
            self::MENU_ARTICLES => 'Articles',
            self::MENU_CATEGORIES => 'Categories',
            self::MENU_LINKS => 'Custom links',
            default => 'Pages'
        };

        return $crud
            ->setEntityLabelInSingular($entityLabelInSingular)
            ->setEntityLabelInPlural($entityLabelInPlural)
        ;
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $subMenuIndex = $this->getSubMenuIndex();

        return $this->menuRepository->getIndexQueryBuilder($this->getFieldNameFromSubMenuIndex($subMenuIndex));
    }

    public function configureFields(string $pageName): iterable
    {
        $subMenuIndex = $this->getSubMenuIndex();

        yield TextField::new('name', 'Title');
        yield NumberField::new('menuOrder', 'Order');
        yield $this->getFieldFromSubMenuIndex($subMenuIndex)
            ->setRequired(true)
        ;
        yield BooleanField::new('isVisible', 'Visible');
        yield AssociationField::new('subMenus', 'Sub menus');
    }

    private function getFieldNameFromSubMenuIndex(int $subMenuIndex): string
    {
        return match ($subMenuIndex) {
            self::MENU_ARTICLES => 'article',
            self::MENU_CATEGORIES => 'category',
            self::MENU_LINKS => 'link',
            default => 'page'
        };
    }

    private function getFieldFromSubMenuIndex(int $subMenuIndex): AssociationField|TextField
    {
        $fieldName = $this->getFieldNameFromSubMenuIndex($subMenuIndex);

        return ($fieldName === 'link') ? TextField::new($fieldName) : AssociationField::new($fieldName);
    }

    private function getSubMenuIndex(): int
    {
        if (($request = $this->requestStack->getMainRequest()) === null) {
            return 0;
        }

        $query = $request->query;

        if (\is_string($referer = $query->get('referrer'))) {
            $result = [];

            if (\is_string($parameters = parse_url($referer, \PHP_URL_QUERY))) {
                parse_str($parameters, $result);
            }

            if (!isset($result['submenuIndex'])) {
                return 0;
            }

            return (int) $result['submenuIndex'];
        }

        return $query->getInt('submenuIndex');
    }
}
