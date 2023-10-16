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

namespace App\Model;

interface TimestampedInterface
{
    public function getCreatedAt(): ?\DateTime;

    public function setCreatedAt(\DateTime $createdAt): static;

    public function getUpdatedAt(): ?\DateTime;

    public function setUpdatedAt(?\DateTime $UpdatedAt): static;
}
