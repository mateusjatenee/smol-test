<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Configuration;

class Bootstrap
{
    public function __construct(
        protected Configuration $config,
        protected TestRunner $testRunner
    ) {
    }

    public static function make(Configuration $configuration): self
    {
        return new static($configuration, new TestRunner($configuration->printer));
    }

    public function run()
    {
        require $this->config->autoloaderPath;

        foreach ($this->config->testSuites as $testSuite) {
            $this->testRunner->run($testSuite);
        }
    }
}
