<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$config = Config::create();
$config->setFinder(Finder::create()->in(__DIR__)->exclude("vendor"));
$config->setRiskyAllowed(true);
$config->setRules([
    "@PSR2" => true,
    "array_syntax" => ["syntax" => "short"],
    "not_operator_with_successor_space" => true,
    "ordered_imports" => ["sortAlgorithm" => "length"],
    "strict_param" => true,
    "strict_comparison" => true,
]);

return $config;
