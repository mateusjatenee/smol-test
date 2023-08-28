<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Runner\Output\Printer;
use Mateusjatenee\SmolTest\Test\TestClass;

class RunTestsForClass
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTests
    ) {
    }

    public function handle(TestClass $testClass): void
    {
        $this->printer->class($testClass);

        $testMethods = $testClass->methods();

        foreach ($testMethods as $method) {
            (new RunTestMethod($this->printer, $this->failedTests))
                ->handle($testClass, $method);
        }
    }
}
