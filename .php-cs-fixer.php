<?php

$finder = PhpCsFixer\Finder::create()->in(['src', 'tests',]);

$config = new PhpCsFixer\Config();
$config->setUsingCache(false);
$config->setRules([
    '@PSR12' => true,
    'no_unused_imports' => true,
    'trailing_comma_in_multiline' => true,
    'method_argument_space' => true,
]);
$config->setFinder($finder);

return $config;
