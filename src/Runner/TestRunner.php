<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Runner\Execution\RunTestsForClass;
use Mateusjatenee\SmolTest\Runner\Output\Printer;
use Mateusjatenee\SmolTest\Tagging\TestClassFinder;
use Symfony\Component\Finder\Finder;

class TestRunner
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTests
    ) {
    }

    public function run(TestSuite $suite): void
    {
        $testFiles = $this->getTestFilesPaths($suite->path);

        foreach ($testFiles as $file) {
            $this->runTestsForFile($file);
        }
    }

    protected function runTestsForFile(string $file): void
    {
        $loadedClasses = get_declared_classes();
        require $file;

        $diff = array_diff(get_declared_classes(), $loadedClasses);
        $testClasses = TestClassFinder::fromArray($diff);

        foreach ($testClasses as $testClass) {
            (new RunTestsForClass($this->printer, $this->failedTests))->handle($testClass);
        }
    }

    /**
     * @return string[]
     */
    protected function getTestFilesPaths(string $path): array
    {
        $finder = new Finder();
        $finder->files()->in($path);
        $tests = [];

        // Since we filter by files later, we can just use the iterator.
        foreach ($finder as $file) {
            $tests[] = $file->getRealPath();
        }

        return $tests;
    }
}
