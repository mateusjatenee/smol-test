<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use Mateusjatenee\SmolTest\Tagging\TestClassFinder;
use Symfony\Component\Finder\Finder;

class TestRunner
{
    public function __construct(
        protected Printer $printer,
        protected FailedTestsCollection $failedTests = new FailedTestsCollection()
    ) {
    }

    public function run(TestSuite $suite)
    {
        $testFiles = $this->getTestFiles($suite->path);

        foreach ($testFiles as $file) {
            $this->runTestsForFile($file);
        }

        $this->printer->showFailedTests($this->failedTests);
    }

    protected function runTestsForFile(string $file): void
    {
        $loadedClasses = get_declared_classes();
        require $file;

        $diff = array_diff(get_declared_classes(), $loadedClasses);
        $testClasses = TestClassFinder::fromArray($diff);

        foreach ($testClasses as $testClass) {
            $testMethods = $testClass->methods();

            foreach ($testMethods as $method) {
                (new RunTestMethod($this->printer, $this->failedTests))
                    ->handle($testClass, $method);
            }
        }
    }

    /**
     * @return string[]
     */
    protected function getTestFiles(string $path): array
    {
        $finder = new Finder();
        $finder->files()->in($path);
        $tests = [];

        foreach ($finder as $file) {
            if (str_ends_with($file->getFilename(), 'Test.php')) {
                $tests[] = $file->getRealPath();
            }
        }

        return $tests;
    }
}
