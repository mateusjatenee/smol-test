<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Argument;
use Mateusjatenee\SmolTest\Configuration;
use Mateusjatenee\SmolTest\Event\Bus;
use Mateusjatenee\SmolTest\Event\TestFailed;
use Mateusjatenee\SmolTest\Event\TestFinished;

class Bootstrap
{
    /**
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
        $finishedTests = new FinishedTestsCollection();
        $testRunner = new TestRunner($this->config->printer, $failedTests);

        Bus::listen(TestFailed::class, fn (TestFailed $event) => $failedTests->push($event->failure));
        Bus::listen(TestFinished::class, fn (TestFinished $event) => $finishedTests->push($event->testRun));
        Bus::listen(TestFinished::class, fn (TestFinished $event) => $this->config->printer->testRun($event->testRun));

        foreach ($this->config->testSuites as $testSuite) {
            $testRunner->run($testSuite, $this->arguments);
        }

        $this->config->printer->showFailedTests($failedTests);
    }
}
