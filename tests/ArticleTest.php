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

use App\Entity\Article;
use App\Tests\Utils\DatabaseTestCase;

class ArticleTest extends DatabaseTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testArticleData()
    {
        $this->createArticle();
        /** @var Article $article */
        $article = $this->entityManager
            ->getRepository(Article::class)->findOneBy(['slug' => 'the-future-of-ai']);

        $this->assertEquals('The Future of AI', $article->getTitle());
        $this->assertEquals('the-future-of-ai', $article->getSlug());
        $this->assertEquals('Test Content', $article->getContent());
        $this->assertInstanceOf(DateTimeImmutable::class, $article->getCreatedAt());
        $this->assertEquals(date('Y-m-d'), $article->getCreatedAt()->format('Y-m-d'));
    }

    public function createArticle(): Article
    {
        // Article Object
        $article = new Article();
        $article->setTitle('The Future of AI');
        $article->setSlug('the-future-of-ai');
        $article->setContent('Test Content');
        $article->setCreatedAt(new DateTimeImmutable());
        $this->entityManager->persist($article);
        $this->entityManager->flush();

        return $article;
    }
}
