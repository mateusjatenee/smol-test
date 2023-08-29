<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Argument;
use Mateusjatenee\SmolTest\Configuration;

class Bootstrap
{
    /**
     * @param  \Mateusjatenee\SmolTest\Configuration  $config
     * @param  Argument[]  $arguments
     */
    public function __construct(
        protected Configuration $config,
        protected ?array $arguments = []
    ) {
    }

    public static function make(Configuration $configuration, array $arguments = []): self
    {
        return new static($configuration, $arguments);
    }

    public function run(): void
    {
        require $this->config->autoloaderPath;

        $failedTests = new FailedTestsCollection();
        $testRunner = new TestRunner($this->config->printer, $failedTests);

        foreach ($this->config->testSuites as $testSuite) {
            $testRunner->run($testSuite, $this->arguments);
        }

        $this->config->printer->showFailedTests($failedTests);
    }
}
