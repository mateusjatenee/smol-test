<?php declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestMethod;
use Mateusjatenee\SmolTest\Test\TestRun;

final readonly class RunTestMethod
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTestsCollection
    )
    {
    }

    public function handle(TestClass $testClass, TestMethod $method): void
    {
        // TODO: handle data providers/multiple tests

        $testRun = (new RunSingleTest())->handle($testClass, $method, $this->printer);

        $this->printer->testRun($testRun);

        if ($testRun->failed()) {
            $this->failedTestsCollection->push($testRun->failure);
        }
    }
}