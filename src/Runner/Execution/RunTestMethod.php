<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner\Execution;

use Mateusjatenee\SmolTest\Runner\FailedTestsCollection;
use Mateusjatenee\SmolTest\Runner\Output\Printer;
use Mateusjatenee\SmolTest\Tagging\DataProvider;
use Mateusjatenee\SmolTest\Test\TestClass;
use Mateusjatenee\SmolTest\Test\TestMethod;

final readonly class RunTestMethod
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTestsCollection,
        protected RunSingleTest $runSingleTest = new RunSingleTest()
    ) {
    }

    public function handle(TestClass $testClass, TestMethod $method): void
    {
//        $dataset = $this->getDataset($testClass);
        $dataset = null;
        
        if ($attributes = $method->getAttributes(DataProvider::class)) {
            /** @var DataProvider $dataProvider */
            $dataProvider = $attributes[0]->newInstance();
            $methodName = $dataProvider->methodName;
            $dataset = $testClass->reflectionClass->getName()::$methodName();
        }

        if (! $dataset) {
            $testRun = $this->runSingleTest->handle($testClass, $method);
            $this->printer->testRun($testRun);
        } else {
            foreach ($dataset as $key => $data) {
                $testRun = $this->runSingleTest->handle($testClass, $method, $data);
                $this->printer->testRun($testRun, $key ? (string) $key : null);
            }
        }

        if ($testRun->failed()) {
            $this->failedTestsCollection->push($testRun->failure);
        }
    }
}
