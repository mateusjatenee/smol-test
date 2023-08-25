<?php

declare(strict_types=1);

namespace Mateusjatenee\SmolTest\Runner;

use ReflectionClass;
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
            $this->runTest($file);
        }

        $this->printer->showFailedTests($this->failedTests);
    }

    protected function runTest(string $file): void
    {
        $loadedClasses = get_declared_classes();
        require $file;

        $diff = array_diff(get_declared_classes(), $loadedClasses);
        $testClasses = array_filter($diff, fn ($class) => str_ends_with($class, 'Test'));

        foreach ($testClasses as $testClass) {
            $reflection = new ReflectionClass($testClass);
            $testMethods = array_filter($reflection->getMethods(),
                fn ($method) => str_starts_with($method->getName(), 'test'));

            foreach ($testMethods as $method) {
                $testRun = (new RunSingleTest())->handle($testClass, $method, $this->printer);
                $this->printer->testRun($testRun);

                if ($testRun->failed()) {
                    $this->failedTests->push($testRun->failure);
                }
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
