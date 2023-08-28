<?php declare(strict_types=1);

use Mateusjatenee\SmolTest\Configuration;
use Mateusjatenee\SmolTest\Runner\TestSuite;

return new Configuration(
    testSuites: [
        TestSuite::path('tests'),
    ],
    autoloaderPath: 'vendor/autoload.php',
);
