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

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    #[Route('/delete-comment/{id}', name: 'delete_comment')]
    public function delete(EntityManagerInterface $entityManager, Comments $comment): Response
    {
        $loggedInUser = $this->getUser();
        $article = $entityManager->getRepository(Article::class)->findOneBy(['id' => $comment->getArticle()->getId()]);
        if ($loggedInUser->getId() === $comment->getAppUser()->getId()) {
            $entityManager->remove($comment);
            $entityManager->flush();
        } else {
            throw new AccessDeniedException('Access Denied: You do not have permission to remove this comment.');
        }
        return $this->redirectToRoute('article_show',['slug' => $article->getSlug()]);
    }
}
