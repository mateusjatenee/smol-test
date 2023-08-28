<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest;

use Mateusjatenee\SmolTest\Runner\Output\DefaultPrinter;
use Mateusjatenee\SmolTest\Runner\Output\Printer;

final class Configuration
{
    /**
     * @param  \Mateusjatenee\SmolTest\Runner\TestSuite[]  $testSuites
     */
    public function __construct(
        public array $testSuites,
        public string $autoloaderPath,
        public Printer $printer = new DefaultPrinter()
    ) {
    }
}
