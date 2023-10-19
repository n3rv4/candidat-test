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


namespace App\Tests;

use App\Entity\Article;
use App\Entity\Comments;
use App\Entity\User;
use App\Tests\Utils\DatabaseTestCase;
use DateTimeImmutable;

class CommentsTest extends DatabaseTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCommentsData()
    {
        $this->createComment();
        /** @var Article $article */
        $article = $this->entityManager
            ->getRepository(Article::class)->findOneBy(['slug' => 'test-article']);
        $comments = $this->entityManager->getRepository(Comments::class)->findBy(['article' => $article]);
        foreach ($comments as $comment) {
            $this->assertEquals('Test Comment', $comment->getContent());
            $this->assertInstanceOf(Article::class, $comment->getArticle());
            $this->assertInstanceOf(User::class, $comment->getAppUser());
            $this->assertInstanceOf(DateTimeImmutable::class, $comment->getCreatedAt());
            $this->assertEquals(date('Y-m-d'), $comment->getCreatedAt()->format('Y-m-d'));
        }
    }

    public function createComment(): Comments
    {
        $this->createAppUser();
        $this->createArticle();
        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(['email' => 'someswararaojagarapu.jagarapu@gmail.com']);
        /** @var Article $article */
        $article = $this->entityManager
            ->getRepository(Article::class)->findOneBy(['slug' => 'test-article']);

        // Article Object
        $comments = new Comments();
        $comments->setContent('Test Comment');
        $comments->setCreatedAt(new DateTimeImmutable());
        $comments->setArticle($article);
        $comments->setAppUser($user);
        $this->entityManager->persist($comments);
        $this->entityManager->flush();

        return $comments;
    }

    public function createAppUser(): User
    {
        // User Object
        $user = new User();
        $user->setEmail("someswararaojagarapu.jagarapu@gmail.com");
        $user->setRoles(['ROLE_ADMIN']);

        $user->setPassword('$2y$13$XF.OzXXLJ0mpsXS0M/Y1vu8ZYhY3.NuD///UDlxFseRJT209nW5/e');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function createArticle(): Article
    {
        // Article Object
        $article = new Article();
        $article->setTitle('Test Article');
        $article->setSlug('test-article');
        $article->setContent('Test Content');
        $article->setCreatedAt(new DateTimeImmutable());
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $article;
    }
}
