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

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @method User getUser()
 */
final class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly EntityRepository $entityRepository,
        private readonly UserPasswordHasherInterface $userPasswordHasher) {}

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('entity.id != :userId')
            ->setParameter('userId', $this->getUser()->getId(), 'uuid')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('email');
        $passwordField = TextField::new('password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms()
        ;

        if ($pageName === Crud::PAGE_EDIT) {
            $passwordField->setRequired(false);
        }
        yield $passwordField;
        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->renderAsBadges([
                'ROLE_ADMIN' => 'success',
                'ROLE_AUTHOR' => 'warning',
            ])
            ->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'Author' => 'ROLE_AUTHOR',
                'User' => 'ROLE_USER',
            ])
        ;
    }

    /** @phpstan-ignore-next-line */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        parent::persistEntity($entityManager, $entityInstance);
    }

    /** @phpstan-ignore-next-line */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $user = $entityInstance;
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        parent::updateEntity($entityManager, $entityInstance);
    }
}
