<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@PSR12' => true,
        'yoda_style' => false,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'increment_style' => [
            'style' => 'post',
        ],
        'ternary_to_null_coalescing' => true,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
        ],
        'phpdoc_separation' => false,
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'blank_line_before_statement' => [
            'statements' => ['break', 'continue', 'declare', 'return', 'try'],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'method' => 'one',
                'property' => 'one',
                'trait_import' => 'none',
            ],
        ],
        'declare_strict_types' => true,
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'parameters']
        ]
    ])
    ->setFinder($finder);
