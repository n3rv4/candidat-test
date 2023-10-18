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

use App\Entity\Comments;
use App\Form\CommentFormType;
use Symfony\Component\Form\Test\TypeTestCase;

class CommentFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'content' => 'This is a test comment content.',
        ];

        $objectToCompare = new Comments();

        // $formData will simulate the form submission data
        $form = $this->factory->create(CommentFormType::class, $objectToCompare);

        $expectedObject = new Comments();
        $expectedObject->setContent($formData['content']);

        // submit the data to the form directly
        $form->submit($formData);

        // Check if the form is correctly submitted and valid
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expectedObject->getContent(), $objectToCompare->getContent());
    }
}
