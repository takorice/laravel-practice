<?php

declare(strict_types=1);

/**
 * @see https://qiita.com/ucan-lab/items/b9c41024c3a16830e85f#php-cs-fixerdistphp
 */

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        // __DIR__ . '/config',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
        // __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12'                                 => true,
        // 'blank_line_after_opening_tag'           => true,
        // 'linebreak_after_opening_tag'            => true,
        // 'declare_strict_types'                   => true,
        'phpdoc_types_order'                     => [
            'null_adjustment' => 'always_last',
            'sort_algorithm'  => 'none',
        ],
        // 'no_superfluous_phpdoc_tags'             => false,
        'global_namespace_import'                => [
            'import_classes'   => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this',
        ],
        'phpdoc_align'                           => [
            'align' => 'vertical',
            // add
            'tags'  => [
                'param',
                'property',
                'var',
            ],
        ],
        'not_operator_with_successor_space'      => true,
        // add
        'no_unused_imports'                      => true,
    ])
    ->setFinder($finder);
