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

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $mediasDirectory = $this->getParameter('medias_directory');
        $uploadsDirectory = $this->getParameter('uploads_directory');

        if (!\is_string($mediasDirectory) || !\is_string($uploadsDirectory)) {
            throw new \RuntimeException('The medias_directory and uploads_directory parameters must be strings.');
        }

        yield TextField::new('name');
        yield TextField::new('altText', 'Alternative text');

        $imageFields = ImageField::new('filename', 'Media')
            ->setBasePath($mediasDirectory)
            ->setUploadDir($uploadsDirectory)
            ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ;

        if ($pageName === Crud::PAGE_EDIT) {
            $imageFields->setRequired(false);
        }

        yield $imageFields;
    }
}
