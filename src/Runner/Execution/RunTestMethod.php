<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Runner\Output\Printer;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestMethod;

final readonly class RunTestMethod
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTestsCollection
    ) {
    }

    public function handle(TestClass $testClass, TestMethod $method): void
    {
        // TODO: handle data providers/multiple tests

        $testRun = (new RunSingleTest())->handle($testClass, $method);

        $this->printer->testRun($testRun);

        if ($testRun->failed()) {
            $this->failedTestsCollection->push($testRun->failure);
        }
    }
}
