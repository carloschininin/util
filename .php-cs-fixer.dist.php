<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

$fileHeaderComment = <<<COMMENT
This file is part of the PIDIA.
(c) Carlos Chininin <cio@pidia.pe>
COMMENT;

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@Symfony' => true,
            '@Symfony:risky' => true,
            'header_comment' => ['header' => $fileHeaderComment, 'separate' => 'both'],
            'linebreak_after_opening_tag' => true,
            'mb_str_functions' => true,
            'no_php4_constructor' => true,
            'no_unreachable_default_argument_value' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'php_unit_strict' => true,
            'phpdoc_order' => true,
            'strict_comparison' => true,
            'strict_param' => true,
        ]
    )
    ->setFinder($finder)
    ->setCacheFile(__DIR__.'/.php_cs.cache');
