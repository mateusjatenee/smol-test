<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Configuration;

class Bootstrap
{
    public function __construct(
        protected Configuration $config,
    ) {
    }

    public static function make(Configuration $configuration): self
    {
        return new static($configuration);
    }

    public function run(): void
    {
        require $this->config->autoloaderPath;

        $failedTests = new FailedTestsCollection();
        $testRunner = new TestRunner($this->config->printer, $failedTests);

        foreach ($this->config->testSuites as $testSuite) {
            $testRunner->run($testSuite);
        }

        $this->config->printer->showFailedTests($failedTests);
    }
}
