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

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Media;
use App\Entity\Menu;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator) {}

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(ArticleCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('BT Blog')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Go to site', 'fa fa-undo', 'app_home');

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('Menus', 'fas fa-list')->setSubItems([
                MenuItem::linkToCrud('Pages', 'fas fa-file', Menu::class)
                    ->setQueryParameter('submenuIndex', MenuCrudController::MENU_PAGES),
                MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Menu::class)
                    ->setQueryParameter('submenuIndex', MenuCrudController::MENU_ARTICLES),
                MenuItem::linkToCrud('Categories', 'fab fa-delicious', Menu::class)
                    ->setQueryParameter('submenuIndex', MenuCrudController::MENU_CATEGORIES),
                MenuItem::linkToCrud('Custom links', 'fas fa-link', Menu::class)
                    ->setQueryParameter('submenuIndex', MenuCrudController::MENU_LINKS),
            ]);
        }

        if ($this->isGranted('ROLE_AUTHOR')) {
            yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('All articles', 'fas fa-newspaper', Article::class),
                MenuItem::linkToCrud('Add', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Categories', 'fab fa-delicious', Category::class),
            ]);

            yield MenuItem::subMenu('Medias', 'fas fa-photo-video')->setSubItems([
                MenuItem::linkToCrud('All medias ', 'fas fa-photo-video', Media::class),
                MenuItem::linkToCrud('Add ', 'fas fa-add', Media::class),
            ]);
        }

        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::subMenu('Users', 'fas fa-user')->setSubItems([
                MenuItem::linkToCrud('All users ', 'fas fa-user-friends', User::class),
                MenuItem::linkToCrud('Add ', 'fas fa-user-plus', User::class)->setAction(Crud::PAGE_NEW),
            ]);
        }
    }
}
