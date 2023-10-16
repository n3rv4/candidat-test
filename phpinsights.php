<?php

declare(strict_types=1);

/*
 * This file is part of the alximy corporate website.
 *
 * Copyright (c) 2023 alximy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'preset' => 'symfony',
    'exclude' => [
        'tests/bootstrap.php',
    ],
    'ide' => 'vscode',
    'requirements' => [
        'min-quality' => 100,
        'min-complexity' => 90,
        'min-architecture' => 100,
        'min-style' => 100,
        'disable-security-check' => true,
    ],
    'config' => [
        \NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses::class => [
            'exclude' => [
                'src/Entity',
            ],
        ],
        \NunoMaduro\PhpInsights\Domain\Insights\CyclomaticComplexityIsHigh::class => [
            'maxComplexity' => 11,
        ],
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class => [
            'lineLimit' => 120,
            'absoluteLineLimit' => 120,
            'ignoreComments' => false,
        ],
    ],
    'remove' => [
        \NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff::class,
        \SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff::class,
        \PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class,
        \SlevomatCodingStandard\Sniffs\Classes\SuperfluousInterfaceNamingSniff::class,
        \SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff::class,
        \SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff::class,
        \PHP_CodeSniffer\Standards\PEAR\Sniffs\WhiteSpace\ScopeClosingBraceSniff::class,
        \PhpCsFixer\Fixer\Basic\BracesFixer::class,
    ],
];
