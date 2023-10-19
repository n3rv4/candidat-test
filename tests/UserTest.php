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

use App\Entity\User;
use App\Tests\Utils\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUserData()
    {
        $this->createUser();
        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(['email' => 'somesh.jagarapu@gmail.com']);

        $this->assertEquals("somesh.jagarapu@gmail.com", $user->getEmail());
        $this->assertEquals('$2y$13$XF.OzXXLJ0mpsXS0M/Y1vu8ZYhY3.NuD///UDlxFseRJT209nW5/e', $user->getPassword());
        $this->assertIsArray($user->getRoles());
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
        $this->assertCount(2, $user->getRoles());
    }
}
