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

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'OEF'
    This file is part of the BT project.

    Copyright (c) 2023 BT

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.
    OEF;

$rules = [
    '@PHP80Migration' => true,
    '@PHP80Migration:risky' => true,
    '@PSR12' => true,
    '@PSR12:risky' => true,
    '@DoctrineAnnotation' => true,
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    'header_comment' => ['header' => $header],
    'array_syntax' => ['syntax' => 'short'],
    'class_definition' => ['multi_line_extends_each_single_line' => true],
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'heredoc_to_nowdoc' => true,
    'php_unit_strict' => true,
    'php_unit_construct' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_order' => true,
    'phpdoc_to_comment' => false,
    'strict_comparison' => true,
    'strict_param' => true,
    'no_extra_blank_lines' => [
        'tokens' => [
            'break',
            'continue',
            'extra',
            'return',
            'throw',
            'use',
            'parenthesis_brace_block',
            'square_brace_block',
            'curly_brace_block',
        ],
    ],
    'echo_tag_syntax' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'semicolon_after_instruction' => true,
    'combine_consecutive_unsets' => true,
    'ternary_to_null_coalescing' => true,
    'declare_strict_types' => true,
    'no_unused_imports' => true,
    'no_superfluous_phpdoc_tags' => [
        'allow_mixed' => true,
    ],
    'phpdoc_no_empty_return' => true,
    'single_blank_line_at_eof' => true,
    'yoda_style' => false,
    'nullable_type_declaration_for_default_null_value' => true,
];

$finder = Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ->notPath('bootstrap.php')
;

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
;
